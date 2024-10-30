@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Список задач</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Поиск по названию или ID" value="{{ request('search') }}">
            <select name="status" class="form-select">
                <option value="">Все статусы</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Выполненные</option>
                <option value="incomplete" {{ request('status') === 'incomplete' ? 'selected' : '' }}>Не выполненные</option>
            </select>
            <button class="btn btn-primary" type="submit">Поиск</button>
        </div>
    </form>

    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Добавить задачу</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Название</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->completed ? 'Выполнена' : 'Не выполнена' }}</td>
                        <td>
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">Редактировать</a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">{{ $task->completed ? 'Вернуть' : 'Выполнить' }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
