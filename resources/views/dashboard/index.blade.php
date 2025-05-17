@extends('layouts.dashboard')
@section('body')
    <!-- start numbers -->
    <div class="grid grid-cols-5 gap-6 xl:grid-cols-2">

        <!-- card -->
        <div class="card mt-6">
            <div class="card-body flex items-center">

                <div class="px-3 py-2 rounded bg-indigo-600 text-white ml-3">
                    <i class="fad fa-wallet"></i>
                </div>

                <div class="flex flex-col">
                    <h1 class="font-semibold"><span class="num-2"></span> Sales</h1>
                    <p class="text-xs"><span class="num-2"></span> payments</p>
                </div>

            </div>
        </div>
        <!-- end card -->

        <!-- card -->
        <div class="card mt-6">
            <div class="card-body flex items-center">

                <div class="px-3 py-2 rounded bg-green-600 text-white ml-3">
                    <i class="fad fa-shopping-cart"></i>
                </div>

                <div class="flex flex-col">
                    <h1 class="font-semibold"><span class="num-2"></span> Orders</h1>
                    <p class="text-xs"><span class="num-2"></span> items</p>
                </div>

            </div>
        </div>
        <!-- end card -->

        <!-- card -->
        <div class="card mt-6 xl:mt-1">
            <div class="card-body flex items-center">

                <div class="px-3 py-2 rounded bg-yellow-600 text-white ml-3">
                    <i class="fad fa-blog"></i>
                </div>

                <div class="flex flex-col">
                    <h1 class="font-semibold"><span class="num-2"></span> posts</h1>
                    <p class="text-xs"><span class="num-2"></span> active</p>
                </div>

            </div>
        </div>
        <!-- end card -->

        <!-- card -->
        <div class="card mt-6 xl:mt-1">
            <div class="card-body flex items-center">

                <div class="px-3 py-2 rounded bg-red-600 text-white ml-3">
                    <i class="fad fa-comments"></i>
                </div>

                <div class="flex flex-col">
                    <h1 class="font-semibold"><span class="num-2"></span> comments</h1>
                    <p class="text-xs"><span class="num-2"></span> approved</p>
                </div>

            </div>
        </div>
        <!-- end card -->

        <!-- card -->
        <div class="card mt-6 xl:mt-1 xl:col-span-2">
            <div class="card-body flex items-center">

                <div class="px-3 py-2 rounded bg-pink-600 text-white ml-3">
                    <i class="fad fa-user"></i>
                </div>

                <div class="flex flex-col">
                    <h1 class="font-semibold"><span class="num-2"></span> memebrs</h1>
                    <p class="text-xs"><span class="num-2"></span> online</p>
                </div>

            </div>
        </div>
        <!-- end card -->

    </div>
    <!-- end nmbers -->

    <!-- strat Analytics -->
    <div class="mt-6 grid grid-cols-2 gap-6 xl:grid-cols-1">

        <!-- update section -->
        <div class="card bg-teal-400 border-teal-400 shadow-md text-white">
            <div class="card-body flex flex-row">

                <!-- image -->
                <div class="img-wrapper w-40 h-40 flex justify-center items-center">
                    <img src="{{asset('assets/dashboard/img/happy.svg')}}" alt="img title">
                </div>
                <!-- end image -->

                <!-- info -->
                <div class="py-2 ml-10">
                    <h1 class="h6">Good Job, {{Auth::user()->name}}!</h1>
                    <p class="text-white text-xs">You've finished all of your tasks for this week.</p>

                    <ul class="mt-4">
                        <li class="text-sm font-light"><i class="fad fa-check-double mr-2 mb-2"></i> Finish Dashboard
                            Design
                        </li>
                        <li class="text-sm font-light"><i class="fad fa-check-double mr-2 mb-2"></i> Fix Issue #74</li>
                        <li class="text-sm font-light"><i class="fad fa-check-double mr-2"></i> Publish version 1.0.6
                        </li>
                    </ul>
                </div>
                <!-- end info -->

            </div>
        </div>
    </div>
    <!-- end update section -->


@endsection
@section('js')

@endsection
