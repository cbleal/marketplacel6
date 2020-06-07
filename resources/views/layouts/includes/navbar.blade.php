<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-bottom: 40px;">

    <a class="navbar-brand" href="{{ route('home') }}">Marketplace L6</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" 
          data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" 
          aria-expanded="false" aria-label="Alterna navegação">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">

      @auth         
      
      <ul class="navbar-nav mr-auto">

        <li class="nav-item @if(request()->is('admin/orders/my*')) active @endif">
          <a class="nav-link" href="{{ route('admin.orders.my') }}">Meus Pedidos</a>
        </li>

        <li class="nav-item @if(request()->is('admin/stores*')) active @endif">
          <a class="nav-link" href="{{ route('admin.stores.index') }}">Loja</a>
        </li>

        <li class="nav-item @if(request()->is('admin/products*')) active @endif">
          <a class="nav-link" href="{{ route('admin.products.index') }}">Produtos</a>
        </li>  
        
        <li class="nav-item @if(request()->is('admin/categories*')) active @endif">
          <a class="nav-link" href="{{ route('admin.categories.index') }}">Categorias</a>
        </li>  

      </ul>

      <div class="my-2 my-lg-0">        
        <ul class="navbar-nav mr-auto">       
          
          {{-- QTDE NOTIFICAÇÕES --}}
          <li class="nav-item">
            <a href="{{ route('admin.notifications.index') }}" class="nav-link">
              <span class="badge badge-danger">{{auth()->user()->unreadNotifications->count()}}</span>
              <i class="fa fa-bell"></i>
            </a>
          </li>
  
          {{-- SAIR --}}
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="event.preventDefault; 
                      document.querySelector('form.logout').submit();">Sair</a>

            <form action="{{ route('logout') }}" method="POST" 
                          class="logout" style="display: none">
              @csrf
            </form>
          </li>

          {{-- USER --}}
          <li class="nav-item">
            <span class="nav-link">{{ auth()->user()->name }}</span>
          </li>
  
        </ul>
      </div>

      @endauth

    </div>
    
  </nav>
  