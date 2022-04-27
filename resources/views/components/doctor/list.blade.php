@extends('layouts.app', ['title' => $title])

@section('content')

@if (Session::has('done'))
    <div class="alert alert-success text-center position-absolute w-50 bg-transparent-success timer-5s" style="top: 15px; left: 25%">
        {{Session::get('done')}}
    </div>
@endif

<div class="card mb-4">
    <div class="card-header">
        <div class="row justify-content-between">
            <div class="w-auto">
                <i class="fas fa-table me-1"></i>
                {{ ucwords($title) }} Info.
            </div>
            <div class="w-auto">
                <a href="{{route('doctors.create')}}" class="btn btn-primary p-1 pt-0 pb-0" id="add" data-toggle="tooltip" title="Add New Doctor">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>

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

                @foreach ($doctors as $doctor)
                    @if ($doctor->employee->user->id == Auth::user()->id)
                        @continue
                    @endif

                    @if (!$doctor->employee->user->username)

                    <tr class="bg-danger">
                        <td class="text-light">Hasn't Registered Yet!</td>
                        <td class="text-light">{{$doctor->employee->user->email}}</td>
                        <td class="text-light">Hasn't Registered Yet!</td>
                        <td class="text-light">
                            <form action="{{route('doctors.destroy', $doctor->id)}}" method="POST" class="p-0">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure to complete this operation?')" type="submit" class="btn border-none text-light p-0">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    @else

                    <tr>
                        <td>
                            <a href="{{route('doctors.show', $doctor->employee->user->username)}}" class="text-decoration-none">
                                {{ucwords($doctor->employee->user->fname . ' ' . $doctor->employee->user->lname)}}
                            </a>
                            <a href="{{route('doctors.edit', $doctor->employee->user->username)}}" class="m-2">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                        <td>{{$doctor->employee->user->email}}</td>
                        <td>{{$doctor->employee->user->phone}}</td>
                        <td>
                            <form action="{{route('doctors.destroy', $doctor->id)}}" method="POST" class="p-0">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure to complete this operation?')" type="submit" class="btn border-none text-danger p-0">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    @endif
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection
