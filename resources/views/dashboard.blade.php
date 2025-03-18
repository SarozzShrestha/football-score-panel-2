@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    
    <aside>
    <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo-wrap">
            <img src="{{ asset('/build/images/designkarkhana_logo.jpg') }}" alt="Logo">

                <!-- <img src= '../../images/' alt=""> -->
        </div>
        <ul>
            <li><a href="" class="active">Dashboard</a></li>
            <li><a href="#">Leagues</a></li>
            <li><a href="#">Teams</a></li>
            <li><a href="#">Players</a></li>
            <li><a href="#">Refrees</a></li>
            <li><a href="#">Matches</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="content">
        <div class="dashboard">
            <div class="dashboard__top">
                <div class="dashboard__top__left">
                    <h2>Football scoring System</h2>
                </div>
                <div class="dashboard__top__right">
                    <div class="user-menu">
                        <span class="user-name">Admin</span>
                        <div class="dropdown">
                            <button class="dropbtn">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H21a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H14"></path>
                                <polyline points="7 11 2 6 7 1"></polyline>
                                <line x1="14" y1="12" x2="2" y2="12"></line>
                            </svg>
                            </button>
                            <div class="dropdown-content">
                                <form method="POST" action="#">
                                    @csrf
                                    <button type="submit">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cards">
                <div class="cards__item">
                    <h3>Create League</h3>
                    <a href="#" class="btn">Create</a>
                </div>
                <div class="cards__item">
                    <h3>Add Players</h3>
                    <a href="#" class="btn">Add</a>
                </div>
                <div class="cards__item">
                    <h3>Add Referees</h3>
                    <a href="#" class="btn">Add</a>
                </div>
                <div class="cards__item">
                    <h3>Add Team</h3>
                    <a href="#" class="btn">Add</a>
                </div>
                <div class="cards__item">
                    <h3>Add Matches</h3>
                    <a href="#" class="btn">Add</a>
                </div>
            </div>
        </div>
     
    </main>
</div>

    </aside>

@endsection