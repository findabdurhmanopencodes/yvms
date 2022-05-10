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
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <i class="fal fa-plus"></i>
                        <!--end::Svg Icon-->
                    </span>Approve</a>

                <!--end::Button-->
            </div>
        </div>

       
          <span>
          
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
             1.   Placement for Training Session-202
            </button>
          </span>

          <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <table width="100%" class="table table-striped  table-sm table-white">

                    <thead>
                        <tr>
        
                            <th colspan="3" width="20%"> Region information</th>
        
                            <th colspan="3" width="80%">Screen out list by Regional State</th>
                         </tr>
                    </thead>
                    <thead>
                        </tr>
                        <th> #</th>
                        <th> Region</th>
                        <th> Co-ordinator</th>
                        <th> Quatoa</th>
                        <th> No of University</th>
                        <th> Zones </th>
                        <th> Action </th>
                      </tr>
        
                    </thead>
        
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($regions as $key => $region)
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td width="20%"> {{ $region->name }}</td>
                                <td width="20%"> Seid Mohammed</td>
                                <th> {{ $region->qoutaInpercent }} %</th>
                                <td> 5 </td>
                                <td> 55 </td>                    
                                <td> 
                                 <a href="{{ route('training_center.placement',[]) }}" class="btn btn-sm btn-primary btn-primary btn-round">
                                 Details    
                                
                               
                                </a>   
                                </td>
                              </tr>
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
