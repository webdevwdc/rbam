@extends('landing_view_page.layouts')
@section('title','Welcome To Homepage')
@section('content')
    <!-- body Start -->
    <div class="prosper-page-home">
        <div class="hero">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-push-6 col-sm-12">
                        <div class="hero-video">
                            <iframe src="https://player.vimeo.com/video/246840744?color=ffffff&amp;title=0&amp;byline=0&amp;portrait=0" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe><p>Learn how it all works in three minutes More <a href="https://vimeo.com/user40162735">Bartertech.com videos</a>.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-md-pull-6 col-sm-12 hidden-xs">
                        <h1 class="text-left">Trade what you have for
                         <span id="example"></span>
                        </h1>
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                 <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="tile-list-component" id="select-a-tile">
                        <div class="col-md-8 col-md-offset-2">
                        <h2 class="landing-lead">Start growing your business, attracting new customers, and building lasting relationships through barter.</h2>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                           <div class="tile photo why-barter">
                                <h3>Why barter in business?</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="tile photo how-does-it-work">
                                <h3>How does it work?</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="tile photo how-will-it-work-for-you">
                                <h3>How will it work for you?</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="tile photo more-questions">
                                <h3>Still more questions?</h3>
                            </div>
                        </div>
                    </div>
                 
                    
                 </div>
            </div>
        </div>
           <div class="subhero gray-lighter" id="why-barter">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                        <div class="subhero-header">
                            <h1>What is barter and why do it in business?</h1>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-1 readable-text">
                            <p>Barter is simply the exchange of goods and services (not haggling for prices). A direct barter deal between two businesses, for example, would be “Company A” providing goods to “Company B” in exchange for an equivalent amount of Company B’s services.</p>

                        <p class="exchange-model-icons">
                            <span class="glyphicon glyphicon-user big" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-resize-horizontal big" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-user big" aria-hidden="true"></span>
                        </p>

                        <p>However, while these direct barter deals are effective, in the modern world they lack flexibility which limits how often they may occur.  The challenge with the direct, one-to-one bartering model is that you might want something that one business has but they may not directly want what you have.</p>

                        <p class="exchange-model-icons">
                            <span class="glyphicon glyphicon-user big" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-resize-horizontal big" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-user big" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-user big" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-user big" aria-hidden="true"></span>
                        </p>

                        <p>By creating a network of members and a currency of “trade dollars” the model now becomes one-to-many and you may now barter with other members with confidence. Business owners love bartering because it saves cash – the profit margin built into goods and services sold allow for more purchasing power. In addition, bartering moves excess inventory and fills up downtime or spare capacity.</p>
                            
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-default panel-225trade">
                            <div class="panel-body">
                                <img src="{{url('landing_page/images/logo-extra-1.png')}}" width="70" height="70" alt="">
                                <h4>We provide a flexible, secure, and fully accountable way for businesses to transact their goods and services with one another.<br><br><strong>Bartertech is based in the great state of Louisiana with the goal of growing nationwide. </strong> </h4>
                            </div>
                        </div>
                            
                        </div>
                    </div>
                </div>
           </div>
           
           <div class="subhero" id="how-does-it-work">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2" style="margin-bottom: 30px;">
                        <div class="subhero-header">
                            <h1>How does it work?</h1>
                        </div>
                    </div>
                </div> <!-- .row -->

                <div class="row">
                    <div class="col-md-6 hidden-sm presentation-glyphs">
                        <span class="glyphicon glyphicon-cloud" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-6 col-sm-12 readable-text">
                        <p>As a Bartertech member, you'll receive a barter card similar to a credit/debit card that is accepted throughout our trade network. The sale of products and services is transacted through our secure online application or with a swipe of your barter card.</p>

                        <div class="col-sm-12 visible-sm presentation-glyphs" style="text-align: center;">
                            <span class="glyphicon glyphicon-cloud" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
                        </div>

                        <p>A trade transaction is similar to a credit/debit card transaction. Bartertech members are paid trade dollars for goods and services they offer through our network and the value is recorded electronically in the member’s account.</p>

                        <p>After the transaction the member can now spend the barter dollars from the sale of their product or services and use their barter dollars to buy any products or services offered from our entire membership. This allows the members to accept trades from one member and use the payment to buy from other members.</p>

                        <p>A small fee is charged  for each barter transaction between any two members which is paid from their "cash barter account" (also known as CBA). A member's cash barter account can also be managed through their online barter account that records each transaction just like your checking account with a bank.</p>
                    </div>
                </div> <!-- .row -->
            </div> <!-- .container -->
        </div>
            <div class="subhero gray-lighter" id="how-will-it-work-for-you">
                <div class="subhero-header">
                            <h1>Let's make trading work for your business.</h1>
                        </div>
                <div class="container">
                    <div class="row">
                         <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="panel panel-default panel-popout panel-work panel-left">
                            <div class="popout-wrapper">
                                <h3>Company size</h3>
                            </div>
                            
                            <div class="panel-body">
                                <h4>Small businesses</h4>
                                
                                <ul class="list-unstyled list-business-types">
                                    <li><span class="glyphicon glyphicon-ok hidden-sm" aria-hidden="true"></span>&nbsp;&nbsp;New customers</li>
                                    <li><span class="glyphicon glyphicon-ok hidden-sm" aria-hidden="true"></span>&nbsp;&nbsp;Increased buying power</li>
                                    <li><span class="glyphicon glyphicon-ok hidden-sm" aria-hidden="true"></span>&nbsp;&nbsp;Conservation of cash flow</li>
                                    <li><span class="glyphicon glyphicon-ok hidden-sm" aria-hidden="true"></span>&nbsp;&nbsp;Alternative financing</li>
                                    <li><span class="glyphicon glyphicon-ok hidden-sm" aria-hidden="true"></span>&nbsp;&nbsp;Enhanced quality of life</li>
                                </ul>

                                <h4>Corporations</h4>
                                
                                <ul class="list-unstyled list-business-types">
                                    <li><span class="glyphicon glyphicon-ok hidden-sm" aria-hidden="true"></span>&nbsp;&nbsp;Convert slow moving inventory into current receivables</li>
                                    <li><span class="glyphicon glyphicon-ok hidden-sm" aria-hidden="true"></span>&nbsp;&nbsp;Put surplus production capacity to use</li>
                                    <li><span class="glyphicon glyphicon-ok hidden-sm" aria-hidden="true"></span>&nbsp;&nbsp;Increase market share with low cash investment</li>
                                </ul>
                            </div>
                        </div>
                         </div>
                         <div class="col-md-4 col-sm-12 col-xs-12">
                           <div class="panel panel-default panel-popout panel-work panel-middle">
                            <div class="popout-wrapper">
                                <h3>Growing Together</h3>
                            </div>
                            
                            <div class="panel-body">
                                <p>We are building a network of allied businesses who refer each other exclusively. If you are like most businesses you get a huge percentage of your business from your own customers who told others about you.</p>
                                <p>Our approach is to seek out businesses to include in our referral network who conduct business the same way you do with honesty and integrity. We want our members to be able to refer anyone in our network knowing that your friends, family and business associates will be well taken care of by our allied businesses.</p>
                            </div>
                        </div>
                         </div>
                         <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="panel panel-default panel-popout panel-work panel-right">
                            <div class="popout-wrapper">
                                <h3>Employee Benefits</h3>
                            </div>
                            
                            <div class="panel-body">
                                <p class="col-md-12 col-md-offset-0 col-sm-10 col-sm-offset-1">Rapidly becoming unaffordable for many small businesses. Gain an excellent opportunity to cut costs while offering employees more! Here are some ideas.</p>
                                
                                <ul class="list-unstyled list-employee-benefits col-sm-12">
                                    <li><span class="glyphicon glyphicon-heart" aria-hidden="true"></span>&nbsp;&nbsp;Health &amp; Dental Plans</li>
                                    
                                    <li><span class="glyphicon glyphicon-heart" aria-hidden="true"></span>&nbsp;&nbsp;Fitness Clubs &amp; Spas</li>
                                    
                                    <li><span class="glyphicon glyphicon-heart" aria-hidden="true"></span>&nbsp;&nbsp;Childcare</li>
                                    
                                    <li><span class="glyphicon glyphicon-heart" aria-hidden="true"></span>&nbsp;&nbsp;Gifts &amp; Vacations</li>
                                </ul>
                            </div>
                        </div>
                         </div>
                    </div>
                </div>
            </div>
            <div class="subhero" id="still-more-questions">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="subhero-header">
                            <h1>Frequently asked questions</h1>
                        </div>
                    </div>
                </div> <!-- .row -->

                <div class="row">
                    <div class="col-md-8 col-md-offset-2 readable-text">
                        <h3>How should I price my product or service?</h3>

                        <p>The price you quote to bartertech.com members is the same price you would quote to a cash paying client. Bartering is simply another method of payment, just like cash or a credit card.</p>

                        <h3>Can I make purchases before I have earned enough trade dollars?</h3>

                        <p>Just like a bank, we offer interest-free lines of credit. Contact our office to get set up. Use bartertech.com to expand your business or form a new business venture when traditional funding is not available!</p>

                        <h3>How are taxes handled?</h3>

                        <p>Barter transactions are assessable and deductible for income tax purposes to the same extent as other cash or credit transactions. The IRS considers one Trade Dollar (T$1) equal to one United States dollar (US$1). When an entity that is a member of a trade exchange makes a taxable supply to another member there is a tax liability. The consideration paid for supplies between members of a trade exchange is the debiting of the recipient’s account and the consideration received is the crediting of the supplier’s account. bartertech.com is required by the IRS to issue a 1099B at the end of each tax year to members participating in the program.</p>
                    </div>
                </div> <!-- .row -->
            </div> <!-- .container -->
        </div>
        

    </div>
    <!-- body End -->

@endsection 
    

     @section('js')
     <script src="{{url('landing_page/js/cycletext.js')}}"></script>
      <script src="{{url('landing_page/js/script.js')}}"></script>
    @endsection