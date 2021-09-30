<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class infomationEmploy extends Model
{
    use HasFactory;
    protected $fillable = [
    'codeEmploy',
    'userNameEmploy',
    'nameEmploy',
    'teleEmploy',
    'emailEmploy',
    'genderEmploy',
    'birthdayEmploy',
    'placeOfBirthEmploy',
    'homeTownEmploy',
    'permanentResidenceEmploy',
    'currentAccommodationEmploy',
    'majorsEmploy',
    'trainingPlacesEmploy',
    'nationEmploy',
    'religionEmploy',
    'qualificationEmploy',
    'graduationYearEmploy',
    'IDCardEmploy',
    'dateRangeEmploy',
    'issuedByEmploy',
    'accountNumberEmploy',
    'bankEmploy',
    'branchBankEmploy',
    'practicingCertificateTVGS',
    'practicingCertificateTVGSEffectiveDate',
    'practicingCertificateATLD',
    'practicingCertificateTVTK',
    'practicingCertificateOther',
    'DateOfReceivingTheJob',
    'Department',
    'Position',
    'socialInsurance',
    'typeOfContract',
    'workStatus',
    'socialInsuranceNumber',
    'dayOff',
    'socialInsurancePremium',
    'descriptionEmploy'
    ,'pathFile'
    ];
}
