

@extends('layouts.guest')
@section('title', 'Contact Us')

@section('content')

    <div class="row">
        
        
        <div class="col-md-8 mx-auto">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                Contct Us
                    </h3>
                </div>
                <div class="card-body">
                    <strong> Address </strong>
                    <p style="text-align:justify;">
                    <ul class="">
                        <li style="text-align:justify;">
                            Ethio-Chinese Friendship Road, Addis Ababa, Ethiopia

                        </li>
                    </ul>
                   
             
                    <p style="text-align:justify;">
                   <strong> </u> Contact Information  </u> </strong> <br>
                    <ul style="text-align:justify;">
                         <li> Email : communication.mop@gmail.com </li>
                         <li> Tel:  ###########</li>
                         <li> PO.BOX :####</li>
                    </ul>
                  <br>   <br>   <br>   <br>   <br>   <br>   <br>   <br>   <br>   <br>
                 </p>
                </div>
            </div>
        </div>


        <div class="col-md-4 mx-auto">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                Share us your feadback
                    </h3>
                </div>
                <div class="card-body">
                 
                    <form action="">
                      <label> Phone</label>
                        <input placeholder="Phone" type="text" class="form-control" name="message"r required><br>
                   <label for=""> Email</label>
                        <input type="text" placeholder="Email" Phone="email" class="form-control" name="message" required><br>
                        <label> Message</label>
                        <textarea  placeholder="Write yout feadback here" cols="5" rows="5" class="form-control" name="message" required> 
                  </textarea>
<br>
                        <button type="button" class="btn btn-primary  float-right"><b>Submit</b></button>
                             <br>
                         

                    </form>
              
             
                </div>
            </div>
        </div>
    </div>
@endsection

