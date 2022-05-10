@extends('layouts.app')
@section('title', 'Placement')
@section('breadcrumb-list')
    <li class="active">Regions</li>
@endsection
@section('breadcrumbTitle', 'Placement')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Placement</a>
    </li>
@endsection

@push('js')
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush
<style>
    table {
        width: 300px;
        border-collapse: collapse;
        font-size: 12px;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 10px;
    }

</style>
@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label"> Last Applicantion placmenet
                   
                </h3>
            </div>
      
        </div>

       
          <span>
          
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
         Oromia->Jimma Zone
            </button>
          </span>

          <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <table width="100%" class="table table-striped  table-sm table-white">

                    <thead>
                        <tr>
        
                            <th colspan="3" width="20%"> University</th>
        
                            <th colspan="13" width="80%">Placement distribution by Regional State</th>
        
        
        
        
                        </tr>
                    </thead>
                    <thead>
                        </tr>
                        <th> #</th>
                        <th>Training Center </th>
                        <th> Intake </th>

                     

                        @foreach ($regions as $key => $region)
                      
                           
                            <th> {{ $region->name }}</th>
                          
                         
                    @endforeach 

                        <th> Action </th>
                      </tr>
        
                    </thead>
        
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($trainining_centers as $key => $trainining_center)
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td>{{ $trainining_center->name }}</td>

                                <td> Intake </td>
                        @foreach ($regions as $key => $region)
                      
                           
                        <td>566 </td>
                      
                     
                @endforeach
              
                                                 
                                <td> 
                                 <a href="#" class="btn btn-sm btn-primary btn-primary btn-round">
                                 Approve
                                </a>   
                                </td> </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
          </div>
       
        
        <br>
        <br>  
       
       
            
            
       
      </div>
    </div>



@endsection
