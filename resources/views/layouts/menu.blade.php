<?php

use Illuminate\Support\Facades\Auth;
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-bottom-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Acorduri De Chitara</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link 
            @if (request()->routeIs('home')) 
              active 
            @endif" 
            aria-current="page" href="{{ env('APP_URL') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link 
            @if (request()->routeIs('tabs.index') || request()->routeIs('tabs.show')) 
              active
            @endif" 
            href="{{ route('tabs.index') }}">{{ __('Tabulaturi') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link 
            @if (request()->routeIs('artists.index') || request()->routeIs('artists.show')) 
              active 
            @endif" 
            href="{{ route('artists.index') }}">{{ __('Artisti') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link 
            @if (request()->routeIs('chords.index') || request()->routeIs('chords.show')) 
              active 
            @endif" 
            href="{{ route('chords.index') }}">{{ __('Acorduri') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link 
            @if (request()->routeIs('users.index') || request()->routeIs('users.show')) 
              active 
            @endif" 
            href="{{ route('users.index') }}">{{ __('Utilizatori') }}</a>
        </li>        
      </ul>
      @auth
      <span class="navbar-text">
	      Salut, <?=Auth::user()->username?>!
      </span>
      <form method="POST" action="{{ route('logout') }}" class="form-inline ms-2">
          @csrf
          <button class="btn btn-secondary" type="submit">Logout</button>
      </form>
      @endauth
      @guest
      <a class="btn btn-secondary" href="{{ route('login') }}">Login</a>
      @endguest
    </div>
  </div>
</nav>