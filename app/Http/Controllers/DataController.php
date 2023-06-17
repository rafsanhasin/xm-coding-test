<?php

namespace App\Http\Controllers;

use App\API\CompanyAPI;
use App\API\StockAPI;
use App\Events\SendEmail;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DataController extends Controller
{
    protected $companyAPI;
    protected $stockAPI;

    /**
     * @param CompanyAPI $companyAPI
     * @param StockAPI $stockAPI
     */
    public function __construct(CompanyAPI $companyAPI, StockAPI $stockAPI)
    {
        $this->companyAPI = $companyAPI;
        $this->stockAPI = $stockAPI;
    }

    /**
     * @return View
     */
    public function index():View {
        $companies = $this->companyAPI->getAllCompany();

        return view('home/index', compact('companies'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws ValidationException
     */
    public function stats(Request $request): View {
        $reqSymbol = $request->input('company_symbol');
        $reqStartDate = $request->input('start_date');
        $reqEndDate = $request->input('end_date');
        $reqEmail = $request->input('email');

        $companies = collect($this->companyAPI->getAllCompany());
        $company = $companies->where('Symbol', $reqSymbol)->first();
        $companySymbols = $companies->pluck('Symbol')->toArray();

        $this->validate($request,[
            'company_symbol'=> ['required', Rule::in($companySymbols)],
            'start_date'=> ['required','date_format:Y-m-d', 'before_or_equal:end_date' ,'before_or_equal:today'],
            'end_date'=> ['required','date_format:Y-m-d', 'after_or_equal:start_date', 'before_or_equal:today'],
            'email'=> ['required', 'email'],
        ]);

        $prices = $this->stockAPI->getStockPrices($reqSymbol);

        $pricesWithinDateRange = [];

        foreach ($prices as $price) {
            $dateParsed = Carbon::createFromTimestamp($price['date']);

            if($dateParsed->between($reqStartDate, $reqEndDate)) {
                $price['date'] = $dateParsed->toDateString();
                $pricesWithinDateRange[] = $price;
            }
        }

        $subject = $company['Company Name'];
        $body['message'] = "From ". $reqStartDate. " to ". $reqEndDate;
        //event(new SendEmail($reqEmail, $subject, $body));

        return view('stat/index', compact('pricesWithinDateRange'));
    }
}
