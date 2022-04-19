@extends('layouts.app', ['title' => $title])

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        {{ ucwords($title) }} Info.
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                
                @foreach ($rows as $row)
                    <tr>
                        <td>
                            <a href="{{route('managers.show', $row->user->username)}}" class="text-decoration-none">
                                {{ucwords($row->user->fname . ' ' . $row->user->lname)}}
                            </a>
                            <a href="{{route('managers.edit', $row->user->username)}}" class="m-2">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                        <td>{{$row->user->email}}</td>
                        <td>{{$row->user->phone}}</td>
                        <td>
                            <form action="{{route('managers.destroy', $row->user->id)}}" method="POST" class="p-0">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure to complete this operation?')" type="submit" class="btn border-none text-danger p-0">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
</div>
@endsection
