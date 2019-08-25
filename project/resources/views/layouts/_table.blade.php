@extends('layouts._control')

@section('route')
    <div class="row">
        <section class="col-lg-12">
            <table class="table table-bordered table-striped table-hover" id="data-table">
                @yield('table_content')
            </table>
        </section>
    </div>
    @yield('footer')
@endsection


