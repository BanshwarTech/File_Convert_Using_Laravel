1 :: download DomPdf in the project
------------------------------------
    composer require barryvdh/laravel-dompdf
    -----------------------------------
    then move to config search dompdf.php if there is not available then use this command:::

    php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider";

    then see again in config folder and check the dompdf.php is available or not available
    -----------------------------------------------------------------------------------------


2 :: export data from in docx file
----------------------------------
    composer require phpoffice/phpword

3 :: export data from in excel file
------------------------------------
    composer require maatwebsite/excel

    php artisan make:export ClientsExport --model=Client 

    go to app=> exports
