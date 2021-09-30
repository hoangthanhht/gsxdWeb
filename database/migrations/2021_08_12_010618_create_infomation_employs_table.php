<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfomationEmploysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infomation_employs', function (Blueprint $table) {
            $table->id();
            $table->text('codeEmploy');
            $table->text('userNameEmploy');
            $table->text('nameEmploy');
            $table->text('teleEmploy')->nullable();
            $table->text('emailEmploy')->nullable();
            $table->text('genderEmploy')->nullable();
            $table->text('birthdayEmploy')->nullable();
            $table->text('placeOfBirthEmploy')->nullable();
            $table->text('homeTownEmploy')->nullable();
            $table->text('permanentResidenceEmploy')->nullable();
            $table->text('currentAccommodationEmploy')->nullable();
            $table->text('majorsEmploy')->nullable();
            $table->text('trainingPlacesEmploy')->nullable();
            $table->text('nationEmploy')->nullable();
            $table->text('religionEmploy')->nullable();
            $table->text('qualificationEmploy')->nullable();
            $table->text('graduationYearEmploy')->nullable();
            $table->text('IDCardEmploy')->nullable();
            $table->text('dateRangeEmploy')->nullable();
            $table->text('issuedByEmploy')->nullable();
            $table->text('accountNumberEmploy')->nullable();
            $table->text('bankEmploy')->nullable();
            $table->text('branchBankEmploy')->nullable();
            $table->text('practicingCertificateTVGS')->nullable();
            $table->text('practicingCertificateTVGSEffectiveDate')->nullable();
            $table->text('practicingCertificateATLD')->nullable();
            $table->text('practicingCertificateTVTK')->nullable();
            $table->text('practicingCertificateOther')->nullable();
            $table->text('DateOfReceivingTheJob')->nullable();
            $table->text('Department')->nullable();
            $table->text('Position')->nullable();
            $table->text('socialInsurance')->nullable();
            $table->text('typeOfContract')->nullable();
            $table->text('workStatus')->nullable();
            $table->text('socialInsuranceNumber')->nullable();
            $table->text('dayOff')->nullable();
            $table->text('socialInsurancePremium')->nullable();
            $table->text('descriptionEmploy')->nullable();
            $table->text('pathFile');        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infomation_employs');
    }
}
