@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать задачу</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Название задачи</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $task->title) }}" required>
        </div>
        <div class="form-group">
            <label for="description">Описание задачи (необязательно)</label>
            <textarea name="description" class="form-control" id="description">{{ old('description', $task->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Обновить задачу</button>
    </form>
</div>
@endsection
