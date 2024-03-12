<?php

namespace App\Http\Controllers\Candidate;

use App\helper\responseHelper;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\CandidateProfile;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobforCandidateController extends Controller
{
    function profileStore(Request $request)
    {

         CandidateProfile::createOrUpdate([


             'contact_number'=> $request->input('contact'),
             'address'=> $request->input('contact'),

             'edu_info_id'=> $request->input('edu_info'),


         ]);
    }

    function jobApplySubmit(Request $request)
    {
        try {
            $count=Application::where('job_id',$request->input('job_id'))->where('candidate_id',Auth::id())->count();

            if(!$count)
            {
                Application::create([
                    'job_id'=>$request->input('job_id'),
                    'candidate_id'=>Auth::id()
                ]);

                return responseHelper::out('success','',201);
            }
            else
            {
                return responseHelper::out('You Already Submitted the Application','',201);
            }





        }
        catch (\Exception $exception)
        {
            return responseHelper::out($exception->getMessage(),'',400);
        }
    }

    function profile(Request $request)
    {
        try {

            foreach ($request->input('education') as $education) {
                Education::updateOrCreate(
                    ['id' => $education['id']],
                    [
                        'degree' => $education['degree'],
                        'school' => $education['school'],
                        'major' => $education['major'],
                        'passed_year' => $education['passed_year'],
                        'cgpa' => $education['cgpa'],
                    ]
                );
            }


//            CandidateProfile::createOrUpdate([
//
//               'contact_number'=> $request->input(''),
//                'address'=> '',
//                'portfolio_url' =>'',
//                'linkedin_url'=>'',
//                'education_id' =>'',
//                'experience_id'=>''

//            ]);



        }

        catch (\Exception $exception)
        {

        }
    }
}
