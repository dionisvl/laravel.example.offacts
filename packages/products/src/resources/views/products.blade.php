@extends('products::layout')

@section('content')

    @isset($errors)
        @foreach($errors as $error)
            <div class="alert alert-danger" role="alert">{{ $error }}</div>
        @endforeach
    @endisset
    @isset($messages)
        @foreach($messages as $msg)
            <div class="alert alert-success" role="alert">{{ $msg }}</div>
        @endforeach
    @endisset

    <blockquote class="blockquote mt-3">
        <p class="mb-0">Hello! It is demo version application for use OpenFoodFacts API.</p>
        <ul>
            <li>First, you can press button "Save" for add food info to current local DB</li>
            <li>Second, you can press button "Update" for update food info from API to local DB</li>
            <li>In this example, all incomplete API elements will be skipped</li>
            <li>You can search anything product by typing text into field "Search" and press button "Search"</li>
        </ul>
        <footer class="blockquote-footer">Good <cite title="Source Title">luck!</cite>
        </footer>
    </blockquote>

    <form class="form-inline" action="{{route('productSearch')}}" method="get">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"
               onkeyup="productsSearch(this.value)" onclick="productsSearch(this.value)" name="searchText">
        <button class="btn btn-outline-success my-2 my-sm-0" onclick="">Search</button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" id="searchResult"></ul>
    </form>

    <h1>Products</h1>

    <table class="table table-hover">
        <th>Actions</th>
        <th>ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Category</th>
        @isset($products->products)
            @foreach($products->products as $product)
                <tr>
                    <td>
                        <form action="{{ route('productStore', ['page' => $page]) }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id ?? null }}"/>
                            <input type="hidden" name="product_name" value="{{ $product->product_name }}"/>
                            <input type="hidden" name="image_url" value="{{ $product->image_url }}"/>
                            <input type="hidden" name="categories" value="{{ $product->categories }}"/>
                            @isset($product->ALREADY_IN_DB)
                                <button type="submit" class="btn btn-success">Update</button>
                            @else
                                <button type="submit" class="btn btn-primary">Save</button>
                            @endisset
                        </form>
                    </td>
                    <td>{{ $product->id ?? null}}</td>
                    <td class="text-center">
                        <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}"
                             style="max-height: 60px">
                    </td>
                    <td>{{$product->product_name}}</td>
                    <td>{{$product->categories}}</td>
                </tr>
            @endforeach
        @endisset

    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item {{ $page === 1 ? 'disabled' : ''  }}">
                <a class="page-link"
                   href="{{ route('productIndex', ['page' => ($page > 1 ? $page - 1 : '')]) }}">Previous page</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="{{ route('productIndex', ['page' => ($page + 1)]) }}">Next page</a>
            </li>
        </ul>
    </nav>

    <script>
        const SERVICE_URL = '{{ config('products.SERVICE_OFFACTS_URL') }}';

        //Очистка результатов AJAX поиска
        function clearSearch() {
            let searchResult = document.getElementById('searchResult');
            searchResult.style.display = 'none';
        }

        //Метод для загрузки каталога из сервера
        function productsSearch(text) {
            if (text === '') {
                clearSearch()
            } else {
                let response = request(SERVICE_URL + 'cgi/search.pl?search_terms=' + text + '&search_simple=1&action=process&json=1', 'GET', null);
                processResponse(response);
            }
        }

        //Обработка промиса
        function processResponse(response) {
            response
                .then(data => {
                    fillSearch(data);
                    // if (data.status === 'ok') {
                    // 	fillSearch(data);
                    // } else if (data.status === 'error') {
                    // 	console.log(data)
                    // } else {
                    // 	console.log(data)
                    // }
                })
        }

        //метод для заполнения блока поиска ответом с сервера
        function fillSearch(data) {
            let items = data.products;
            console.log(items);
            let totalItems = '';
            let productStore = '{{ route('productStore', ['page' => $page]) }}';
            let csrf_token = '{{ csrf_token() }}';
            for (let item in items) {
                console.log(items[item]);
                let id = items[item].id;
                let itemTitle = items[item].product_name;
                let itemImage = items[item].image_url;
                let itemCategory = items[item].categories;
                if (itemTitle === '') {
                    continue;
                }
                if (itemCategory === '') {
                    continue;
                }
                totalItems += `
<li role="presentation">
<div style="border: 1px solid aquamarine">
<img src="${itemImage}" style='height: 40px;width: 40px;'><span> ${id}</span> - <span>${itemTitle}</span> - <span>${itemCategory}</span>
</div>
</li>
`;
            }
            let searchResult = document.getElementById('searchResult');
            if (totalItems === '') {
                totalItems = `<div>Nothing found</div>`;
            }
            searchResult.innerHTML = totalItems;
            searchResult.style.display = 'block';
        }

        //Universal HTTP-REST request method
        function request(url, method, payload) {
            console.log(url);
            let params = {
                method: method,
            };
            if (payload !== null) {
                let postParams = {
                    body: JSON.stringify(payload),
                    headers: new Headers({
                        'Accept': 'application/json',
                        'Content-type': 'application/json',
                        //'X-CSRF-Token': document.querySelector("meta[name='_token']").getAttribute('content')
                    })
                }
                params = {...params, ...postParams};
            }

            return fetch(url, params)
                .then(r => r.json())
                .catch(error => console.error(error))
        }
    </script>
@endsection
