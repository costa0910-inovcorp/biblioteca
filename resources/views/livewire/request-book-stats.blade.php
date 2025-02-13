<div class="sm:rounded-lg col flex justify-center">
{{--    # Requisições Ativas, # Requisições nos últimos 30 dias, # Livros entregues Hoje.--}}
    {{--                <p>Stats here, only admins gonna see this!</p>--}}
    <div class="stats shadow">
        <div class="stat place-items-center">
{{--            Requisições Ativas--}}
            <div class="stat-title">Active Requests</div>
            <div class="stat-value">{{ $activeRequests }}</div>
{{--            <div class="stat-desc">From January 1st to February 1st</div>--}}
        </div>

        <div class="stat place-items-center">
{{--            Requisições nos últimos 30 dias--}}
            <div class="stat-title">Last 30 days requests</div>
            <div class="stat-value text-primary">{{ $last30DaysRequests }}</div>
{{--            <div class="stat-desc text-primary">↗︎ 40 (2%)</div>--}}
        </div>

        <div class="stat place-items-center">
{{--            Livros entregues Hoje--}}
            <div class="stat-title">Books returned today</div>
            <div class="stat-value">{{ $returnedBooksToday }}</div>
{{--            <div class="stat-desc">↘︎ 90 (14%)</div>--}}
        </div>
    </div>
</div>
