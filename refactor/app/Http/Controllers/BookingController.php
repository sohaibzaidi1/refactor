<?php

namespace DTApi\Http\Controllers;

use DTApi\Models\Job;
use DTApi\Http\Requests;
use DTApi\Models\Distance;
use Illuminate\Http\Request;
use DTApi\Repository\BookingRepository;

class BookingController extends Controller
{
    private $repository;

    public function __construct(BookingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $response = $this->repository->getUsersJobs($request->get('user_id'));

        if ($request->user()->user_type === env('ADMIN_ROLE_ID') || $request->user()->user_type === env('SUPERADMIN_ROLE_ID')) {
            $response = $this->repository->getAll($request);
        }

        return response($response);
    }

    public function show($id)
    {
        $job = $this->repository->with('translatorJobRel.user')->find($id);

        return response($job);
    }

    public function store(Request $request)
    {
        $response = $this->repository->store($request->user(), $request->all());

        return response($response);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $this->repository->updateJob($id, $data, $request->user());

        return response('Job updated successfully!');
    }

    public function immediateJobEmail(Request $request)
    {
        $response = $this->repository->storeJobEmail($request->all());

        return response($response);
    }

    public function getHistory(Request $request)
    {
        $response = $this->repository->getUsersJobsHistory($request->get('user_id'), $request);

        return response($response);
    }

    public function acceptJob(Request $request)
    {
        $response = $this->repository->acceptJob($request->all(), $request->user());

        return response($response);
    }

    public function acceptJobWithId(Request $request)
    {
        $response = $this->repository->acceptJobWithId($request->get('job_id'), $request->user());

        return response($response);
    }

    public function cancelJob(Request $request)
    {
        $response = $this->repository->cancelJobAjax($request->all(), $request->user());

        return response($response);
    }

    public function endJob(Request $request)
    {
        $response = $this->repository->endJob($request->all());

        return response($response);
    }

    public function customerNotCall(Request $request)
    {
        $response = $this->repository->customerNotCall($request->all());

        return response($response);
    }

    public function getPotentialJobs(Request $request)
    {
        $response = $this->repository->getPotentialJobs($request->user());

        return response($response);
    }

    public function distanceFeed(Request $request)
    {
        $distanceFeed = new DistanceFeed($request->get('jobid'), $request->get('distance'), $request->get('time'));
        $distanceFeed->updateJob();

        return response('Record updated!');
    }

    public function reopen(Request $request)
    {
        $response = $this->repository->reopen($request->all());

        return response($response);
    }

    public function resendNotifications(Request $request)
    {
        $this->repository->sendNotificationTranslator($request->get('jobid'), '*');

        return response(['success' => 'Push sent']);
    }

    public function resendSMSNotifications(Request $request)
    {
        try {
            $this->repository->sendSMSNotificationToTranslator($request->get('jobid'));
            return response(['success' => 'SMS sent']);
        } catch (\Exception $e) {
            return response(['success' => $e->getMessage()]);
        }
    }
}


/**
 * 
 * 
Overall, the code is well-written and easy to understand. 
It is well-formatted and structured, and the logic is clear and concise.

What makes it amazing code

I wouldn't say that the code is amazing, but it is certainly good code. 
There are a few things that could be improved, but overall it is a solid piece of work.

What makes it ok code

One thing that could be improved is the use of dependency injection. 
Currently, the code relies on global variables to access the repository and the user. 
This makes the code less testable and maintainable.
Another thing that could be improved is the error handling. 
The code does not currently handle errors in a very graceful way. 
For example, if the repository fails to save a job, the code will simply throw an exception. 
It would be better to handle the error more gracefully and return a more informative error message to the user.

How would have done it

If I were to rewrite the code, I would use dependency injection to inject the repository and the user into the controller. 
I would also improve the error handling to make the code more robust.

Thoughts on formatting, structure, logic

As I mentioned before, the code is well-formatted, structured, and logical.

Overall assessment

Overall, the code is well-written and easy to understand. 
It is well-formatted and structured, and the logic is clear and concise. 
There are a few things that could be improved, but overall it is a solid piece of work.
 */