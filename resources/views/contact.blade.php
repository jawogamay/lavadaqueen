@extends('layouts.web')
@section('content')
    <div class="contact">
        <div class="container">
        <h4 class="tittles-w3agileits">Contact <span>U</span>s</h4>
            <div class="col-md-4 wthree_contact_left">
                <h6>About Us</h6>
                <p class="para-w3-agile">Lorem ipsum <span>Household Laundry</span> dolor sit amet 
                    <span>Dry Cleaning</span> interdum sed aliquet quis.</p>
                <div class="info-img-agileits">
                    <div class="info1"></div>
                    <div class="info2"></div>
                    <div class="info3"></div>
                    <div class="clearfix"> </div>
                </div>
                <h6>Servicing Hours</h6>
                <ul>

                    <li><p> F. Sotto </p>
                        <span>Monday-Sunday</span> 10am - 8pm </li>
                    <li><p>Ayala Mall</p>
                        <span>Monday-Sunday</span>  10am - 8pm</li>
                </ul>
            </div>
            <div class="col-md-8 wthree_contact_left">
                <h6>Send us an Email</h6>
                <form action="#" method="post">
                        <div class="col-md-6 wthree_contact_left_grid">
                            <input type="text" name="Name" placeholder="Name" required="">
                            <input type="email" name="Email" placeholder="Email" required="">
                        </div>
                        <div class="col-md-6 wthree_contact_left_grid">
                            <input type="text" name="Telephone" placeholder="Telephone" required="">
                            <input type="text" name="Subject" placeholder="Subject" required="">
                        </div>
                        <div class="clearfix"> </div>
                        <textarea name="Message" placeholder="Message..." required=""></textarea>
                        <input type="submit" value="Submit">
                        <input type="reset" value="Clear">
                    </form>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>

@endsection