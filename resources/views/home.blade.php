@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1 class="mb-4">Добро пожаловать, {{ auth()->user()->name }}!</h1>

    <p>Вы можете управлять своими задачами, нажав на кнопку ниже.</p>

    <a href="{{ route('tasks.index') }}" class="btn btn-primary btn-lg">Перейти к задачам</a>

    <div class="mt-4">
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Выйти</button>
        </form>
    </div>
</div>
@endsection
