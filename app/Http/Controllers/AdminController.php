<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Post;
use App\BQuestion;
use App\Category;
use App\SubCategory;
use App\BData;

use Carbon\Carbon;

class AdminController extends Controller
{

    /**
     * Get Master Blade Template View
     * Let Vuejs Backend
     * @return [view] [admin.master]
     */
    public function getMasterView() {
        return view('admin.master');
    }

    public function show(){

    	$users = User::all();
    	$categories = Category::all();
    	$subCategories = SubCategory::all();
    	$posts = Post::all();
    	$questions = BQuestion::all();
    	$bdatas = BData::all();

    	$date = Carbon::now();
    	$start_of_week = $date->startOfWeek();

    	$date = Carbon::now();
    	$end_of_week = $date->endOfWeek();

    	$newUsers = User::whereBetween('created_at', array($start_of_week, $end_of_week) )->get();

    	$newCategories = Category::whereBetween('created_at', array($start_of_week, $end_of_week) )->get();

    	$newSubCategories = SubCategory::whereBetween('created_at', array($start_of_week, $end_of_week) )->get();

    	$newPosts = Post::whereBetween('created_at', array($start_of_week, $end_of_week) )->get();

    	$newQuestions = BQuestion::whereBetween('created_at', array($start_of_week, $end_of_week) )->get();

    	$newBDatas = BData::whereBetween('created_at', array($start_of_week, $end_of_week) )->get();
    	
    	return view('admin.dashboard.show',compact(['users','categories','subCategories','posts','questions','bdatas','newUsers','newCategories','newSubCategories','newPosts','newQuestions','newBDatas']));
    }
}
