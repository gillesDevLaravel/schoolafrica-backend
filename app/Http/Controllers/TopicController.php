<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Http\Requests\Staffs\TopicRequest;
use App\Http\Requests\Staffs\TopicGetAllRequest;
use App\Http\Resources\Staffs\TopicResource;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Log;

/**
 * @group Topic
 */
class TopicController extends BaseController
{
    /**
     * Afficher la liste des topics
     *
     * @param TopicGetAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(TopicGetAllRequest $request)
    {
        try {
            $topic  = $request->validated();
            $idLesson = $request['idLesson'] ?? null;
            $idSection = $request['idSection'] ?? null;

            $topics = Topic::where('idSchool',$topic['idSchool']);

            if(!is_null($idSection)) $topics = $topics->where('idSection',$topic['idSection']);

            if(!is_null($idLesson)) $topics = $topics->where('idLesson',$topic['idLesson']);

            return TopicResource::collection(
                $topics
                    ->orderBy("id", "desc")
                    ->get()
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopicRequest $request)
    {
        try {
            $topic = $request->validated();

            $topic = new Topic();

            $topic->name = $request['name'];
            $topic->description = $request['description'];
            $topic->startDate = $request['startDate'];
            $topic->endDate = $request['endDate'];
            $topic->duration = $request['duration'];
            $topic->status = $request['status'];
            $topic->observation = $request['observation'] ?? null;
            $topic->idLesson = $request['idLesson'];
            $topic->idSchool = $request['idSchool'];
            $topic->idSection = $request['idSection'];
            $topic->created_by = auth()->user()->id;
            $topic->save();

            return new TopicResource($topic);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic,$id)
    {
        try {
            $topic = Topic::find($id);
            return new TopicResource($topic);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TopicRequest $request, Topic $topic,$id)
    {
        try {
            $topic = Topic::find($id);
            $topic->name = $request['name'];
            $topic->description = $request['description'];
            $topic->startDate = $request['startDate'];
            $topic->endDate = $request['endDate'];
            $topic->duration = $request['duration'];
            $topic->status = $request['status'];
            $topic->observation = $request['observation'] ?? $topic['observation'];
            $topic->idLesson = $request['idLesson'];
            $topic->idSchool = $request['idSchool'];
            $topic->idSection = $request['idSection'];
            $topic->created_by = auth()->user()->id;
            $topic->save();

            return new TopicResource($topic);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic,$id)
    {
        try {
            $topic = Topic::find($id);
            $topic->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
