@extends('layouts.frontend_app')

@section('title', 'صرف عملة')

@section('content')

    <style>
        .container-jobs {
            background: white;
        }

        a.btn.btn-sm.btn-info {
            visibility: hidden !important;
        }
        .panel-footer {
            visibility: hidden !important;
        }
        .panel-footer {
            padding: 10px 15px;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
            visibility: hidden;
        }
        @media (min-width: 320px) and (max-width: 1440px) {
            a.btn.btn-sm.btn-info {
                visibility: hidden !important;
            }
            .panel-footer {
                visibility: hidden !important;
            }
        }
    </style>



    <div class="contain-sec py-4">
        <div class="container-jobs py-2 mt-5">
            <!-- START CODE Attention! Do not modify this code; -->
            <script>
                var fm = "USD";
                var to = "BTC,AUD,GBP,EUR,CNY,JPY,RUB,EGP,SYP";
                var tz = "timezone";
                var sz = "1x423";
                var lg = "en";
                var st = "info";
                var cd = 1;
                var am = 1
            </script>
            <script src="//currencyrate.today/exchangerates"></script>
            <div style="text-align:right"><a href="https://currencyrate.today" hidden>CurrencyRate</a></div>
            <!-- Attention! Do not modify this code; END CODE -->
        </div>


        <div class="container-jobs py-2 mt-5">
            <!-- START CODE Attention! Do not modify this code; -->
            <script>
                var fm = "EUR";
                var to = "USD";
                var tz = "timezone";
                var sz = "1x1";
                var lg = "en";
                var st = "info";
                var lr = "1";
                var rd = "0";
            </script>
            <script src="//currencyrate.today/converter"></script>
            <div style="text-align:right"><a href="https://currencyrate.today" hidden>CurrencyRate</a></div>
            <!-- Attention! Do not modify this code; END CODE -->



            {{-- <fxwidget-cc amount="100" decimals="2" large="false" shadow="true" symbol="true" grouping="true" border="false"
                from="USD" to="EUR" background-color="#BBD2C5" background="linear-gradient(203deg,#BBD2C5,#536976)"
                border-radius="0.25"></fxwidget-cc><a href="https://currencyrate.today/" hidden>CurrencyRate</a>
            <script async src="https://s.fx-w.io/widgets/currency-converter/latest.js"></script>

            <fxwidget-cc amount="100" decimals="7" large="false" shadow="true" symbol="true" grouping="true" border="false"
                from="USD" to="EUR" background-color="#348F50" background="linear-gradient(203deg,#348F50,#56B4D3)"
                border-radius="0.25"></fxwidget-cc><a href="https://currencyrate.today/" hidden>CurrencyRate</a>
            <script async src="https://s.fx-w.io/widgets/currency-converter/latest.js"></script>

            <fxwidget-cc amount="1" decimals="2" large="false" shadow="true" symbol="true" grouping="true" border="false"
                from="USD" to="EUR" background-color="#77A1D3" background="linear-gradient(120deg,#77A1D3,#79CBCA,#E684AE)">
            </fxwidget-cc><a href="https://currencyrate.today/" hidden>CurrencyRate</a>
            <script async src="https://s.fx-w.io/widgets/currency-converter/latest.js"></script> --}}

        </div>
    </div>

    {{-- <div class="contain-sec py-4">
        <div class="container-jobs py-2 mt-5">

            <fxwidget-er inverse="false" amount="1" decimals="2" large="false" shadow="true" symbol="true" flag="true"
                changes="true" grouping="true" border="false" main-curr="USD"
                sel-curr="BTC,EUR,CAD,CHF,JPY,EGP,INR,UAH,CNH,SYP" background-color="#085078"
                background="linear-gradient(120deg,#085078,#85D8CE)"></fxwidget-er><a
                href="https://currencyrate.today/">CurrencyRate</a>
            <script async src="https://s.fx-w.io/widgets/exchange-rates/latest.js"></script>

            <fxwidget-er inverse="false" amount="1" decimals="2" large="false" shadow="true" symbol="true" flag="true"
                changes="true" grouping="true" border="false" main-curr="USD"
                sel-curr="BTC,EUR,CAD,CHF,JPY,EGP,INR,UAH,CNH,SYP" background-color="#77A1D3"
                background="linear-gradient(120deg,#77A1D3,#79CBCA,#E684AE)"></fxwidget-er><a
                href="https://currencyrate.today/" hidden>CurrencyRate</a>
            <script async src="https://s.fx-w.io/widgets/exchange-rates/latest.js"></script>

        </div>
    </div> --}}




@endsection
