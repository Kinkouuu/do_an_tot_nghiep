<h3 class="footer-heading mb-4 text-white">Chi nhánh</h3>
<ul class="list-unstyled">
    @foreach($branches as $branch)
        <li> {{ $branch->name }}:
            <br>{{ $branch->address }} - {{ $branch->city }}
            <br>Hotline: <a href="tel:{{ $branch->phone }}">{{ $branch->phone }}</a>
        </li>

    @endforeach
</ul>
