<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module\Job;
use Illuminate\Support\Str;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateDummyData()
    {
        $categories = ['Engineer', 'Marketing', 'Design', 'Finance'];
        $locations = ['Kalimantan Timur', 'Kalimantan Barat', 'Kalimantan Utara'];

        for ($i = 0; $i < 20; $i++) {
            $skills = ['PHP', 'JavaScript', 'Python', 'SQL', 'Linux', 'Cloud Computing'];
            shuffle($skills);
            Job::create([
                'job_title' => 'Job Title ' . $i,
                'code_job' => strtoupper(Str::random(6)),
                'category' => $categories[array_rand($categories)],
                'contract_status' => ['full-time', 'contract'][rand(0, 1)],
                'location' => $locations[array_rand($locations)],
                'experience_years' => rand(0, 20),
                'job_description' => 'This is a description for job ' . $i,
                'skills_required' => array_slice($skills, 0, rand(1, 5))
            ]);
        }

        return redirect()->route('jobs.index')->with('success', 'Dummy data generated.');
    }
}
