@extends('layouts.app')

@section('content')

<div class="col-12">
    <a href="{{ route('admin.notifications.read.all') }}" class="btn btn-success mb-3">
        Marcar todas como lidas
    </a>

    <hr>
</div>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Notificação</th>
            <th>Criado em</th>
            <th class="text-center">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($unreadNotifications as $n)
            <tr>                
                <td>{{ $n->data['message'] }}</td>
                <td>{{ $n->created_at->locale('pt')->diffForHumans() }}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('admin.notifications.read', ['notification' => $n->id]) }}" class="btn btn-sm btn-primary">
                            Marcar como lida
                        </a>                        
                    </div>                  
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">
                    <div class="alert alert-warning">
                        Sem notificações.
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
