@extends('layout.admin-layout')

@section('workspace')
<h1 class="mb-4">Chart View</h1>
<canvas id="myChart" height="100px"></canvas>

@endsection
@push('other-scripts')
  <script type="text/javascript">
   var labels =  {{ Js::from($labels) }};console.log(labels);
      var users =  {{ Js::from($data) }};console.log(users);

      const data = {
        labels: labels,
        datasets: [{
          label: 'My First dataset',
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: users,
        }]
      };

      const config = {
        type: 'bar',
        data: data,
        options: {}
      };

      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
  </script>
  @endpush
