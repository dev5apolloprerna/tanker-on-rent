<?php 
if(auth()->user())
{
$roleid = auth()->user()->role_id;
}else{

$roleid = Auth::guard('web_employees')->user()->role_id;
}
?>
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu"></span></li>
                 <li class="nav-item">
                    <a class="nav-link menu-link @if (request()->routeIs('home')) {{ 'active' }} @endif"
                        href="{{ route('home') }}">
                        <i class="mdi mdi-speedometer"></i>
                        <span data-key="t-dashboards">Dashboards (ડેશબોર્ડ)</span>
                    </a>
                </li>
                @if($roleid == '1' && $roleid != '2')
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button"
                            aria-expanded="true" aria-controls="sidebarMore">
                            <i class="fa fa-list text-white"></i>Master Entry (માસ્ટર એન્ટ્રી)</a>
                        <div class="menu-dropdown collapse show" id="sidebarMore" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('tanker.index') }}" class="nav-link {{ request()->is('admin/tanker*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-truck"></i>
                                        Tanker Master (ટેન્કર માસ્ટર)
                                    </a>
                                </li>
                                <li class="nav-item">
                                  <a href="{{ route('rent-prices.index') }}"
                                     class="nav-link {{ request()->routeIs('rent-prices.*') ? 'active' : '' }}">
                                    <i class="fa fa-rupee-sign me-2"></i> Rent Prices (ભાડાની કિંમતો)
                                  </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('godown.index') }}" class="nav-link {{ request()->is('admin/godown*') ? 'active' : '' }}">
                                        <i class="fas fa-warehouse"></i> Godown (ગોડાઉન)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.daily-expence-types.index') }}" class="nav-link {{ request()->is('admin.daily-expence-types*') ? 'active' : '' }}">
                                        <i class="fas fa-tags"></i> Expense Types(ખર્ચના પ્રકારો)
                                    </a>
                                </li>
                               <li class="nav-item">
                                  <a href="{{ route('admin.daily-expences.index') }}"
                                     class="nav-link {{ request()->routeIs('admin.daily-expences.*') ? 'active' : '' }}">
                                    <i class="fas fa-receipt me-2"></i>
                                    <span>Daily Expenses (દૈનિક ખર્ચ)</span>
                                  </a>
                                </li>

                                <li class="nav-item">
                                        <a class="nav-link {{ request()->is('admin/payment-received-user*') ? 'active' : '' }}" 
                                           href="{{ route('payment-received-user.index') }}">
                                            <i class="fas fa-user-check me-2"></i>
                                            <span>Payment Received By (દ્વારા ચુકવણી પ્રાપ્ત થઈ છે)</span>
                                        </a>
                                    </li>

                            </ul>
                        </div>
                    </li>
                   
                        <li class="nav-item">
                            <a href="{{ route('customer.index') }}" class="nav-link {{ request()->is('admin/customer*') ? 'active' : '' }}">
                                <i class="fas fa-users"></i> <span>Customer (ગ્રાહક)</span>
                            </a>
                        </li>
                        {{-- ======== Payment Received User ======== --}}
                        

                        <li class="nav-item">
                        <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button"
                            aria-expanded="true" aria-controls="sidebarMore">
                            <i class="fa fa-list text-white"></i>Employees Entry (કર્મચારીઓની એન્ટ્રી)</a>
                            <div class="menu-dropdown collapse show" id="sidebarMore" style="">
                            <ul class="nav nav-sm flex-column">      
                                    
                                <li class="nav-item">
                                    <a href="{{ route('employee.index') }}" class="nav-link {{ request()->is('admin/employee*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-users"></i>Employees(કર્મચારીઓ)
                                    </a>
                                </li>
                                 <li class="nav-item">
                                  <a href="{{ route('attendance.index',['date'=>now()->toDateString()]) }}"
                                     class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                                    <i class="fa fa-calendar-check me-2"></i> Attendance(હાજરી)
                                  </a>
                                </li>
                                <li class="nav-item">
                                  <a href="{{ route('emp-salaries.index') }}"
                                     class="nav-link {{ request()->routeIs('emp-salaries.*') ? 'active' : '' }}">
                                    <i class="fa fa-money-bill-wave me-2"></i> Employee Salary(કર્મચારીનો પગાર)
                                  </a>
                                </li>
  
                            </ul>
                        </div>
                    </li>
                        
                        <!--<li class="nav-item">
                            <a href="{{ route('vendor.index') }}" class="nav-link {{ request()->is('admin/vendor*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-handshake"></i>Vendors
                            </a>
                        </li>-->
                        <li class="nav-item">
                            <a href="{{ route('orders.index') }}" class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-invoice"></i>Orders(ઓર્ડર)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('daily-orders.index') }}" class="nav-link {{ request()->is('admin/daily-orders*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-invoice"></i>Daily Order(દૈનિક ઓર્ડર)
                            </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{ route('employee-extra-withdrawal.index') }}"
                             class="nav-link {{ request()->is('admin/employee-extra-withdrawal*') ? 'active' : '' }}">
                             <i class="fas fa-hand-holding-usd me-2"></i>
                             <span>Employee Withdrawal (કર્મચારી ઉપાડ)</span>
                          </a>
                        </li>


                        <li class="nav-item">
                        <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button"
                            aria-expanded="true" aria-controls="sidebarMore">
                            <i class="fa fa-list text-white"></i>Reports (અહેવાલો) </a>
                        <div class="menu-dropdown collapse show" id="sidebarMore" style="">
                            <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                              <a href="{{ route('admin.expence-report.index') }}" 
                                 class="nav-link {{ request()->is('admin/expence-report*') ? 'active' : '' }}">
                                 <i class="fas fa-file-invoice-dollar me-2"></i>
                                 <span>Expense Report (ખર્ચ અહેવાલ)</span>
                              </a>
                            </li>

                            <li class="nav-item">
                              <a href="{{ route('admin.attendance-report.index') }}" 
                                 class="nav-link {{ request()->is('admin/attendance-report*') ? 'active' : '' }}">
                                <i class="fas fa-user-clock me-2"></i>
                                <span>Attendance Report (હાજરી અહેવાલ)</span>
                              </a>
                            </li>
                             <li class="nav-item">
                                  <a class="nav-link {{ request()->is('reports.collection','reports.collection.*') ? 'active' : '' }}"
                                     href="{{ route('reports.collection') }}">
                                    <i class="fa fa-wallet me-2"></i> Payment Collection Report (ચુકવણી સંગ્રહ અહેવાલ)
                                  </a>
                                </li>


                        </ul>
                    </div>
                </li>


                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>