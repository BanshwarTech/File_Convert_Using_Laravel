1 :: download DomPdf in the project
------------------------------------
    composer require barryvdh/laravel-dompdf
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
    
4 :: upload project on github from the own system 
-------------------------------------------------
     git remote add origin https://github.com/BanshwarTech/File_Convert_Using_Laravel.git
     git branch -M main
     git init 
     git add .
     git commit -m "first commit"
     git push -u origin main

In this project all fetures :: PdfFileDownload, CsvFileDownload, DocxFileDowmload, ExcelFileDowmload, JsonFileDownload, XMLFileDownload 
<br/><br/>
5 :: run this project to own system 
-----------------------------------
     git clone https://github.com/BanshwarTech/File_Convert_Using_Laravel.git
     composer install
     cp .env.example .env (Update project .env file and define the database name)
     php artisan key:generate
     php artisan migrate
     php artisan serve

