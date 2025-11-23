 {{--
   Company: CETAM
   Project: QPK
   File: dashboard.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Dashboard view refactored to extend 'layouts.app' and use standardized <x-icon> components. |
        Changelog:

   - ID: 2 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Fixed Livewire MultipleRootElementsDetectedException by wrapping content in a single root div. |

   - ID: 3 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Removed @extends and @section to fix Livewire layout conflict. Sidebar is now handled by the component class. |
--}}

 <div>
    {{-- Toolbar and Actions --}}
    <div class="py-4">
        <div class="dropdown">
            <button class="btn btn-gray-800 d-inline-flex align-items-center me-2 dropdown-toggle" 
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <x-icon name="plus" class="me-2" size="xs" />
                New Task
            </button>
            <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <x-icon name="userPlus" class="text-gray-400 me-2" />
                    Add User
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <x-icon name="grid" class="text-gray-400 me-2" />
                    Add Widget
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <x-icon name="upload" class="text-gray-400 me-2" />
                    Upload Files
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <x-icon name="shield" class="text-gray-400 me-2" />
                    Preview Security
                </a>
                <div role="separator" class="dropdown-divider my-1"></div>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <x-icon name="star" class="text-danger me-2" />
                    Upgrade to Pro
                </a>
            </div>
        </div>
    </div>

    {{-- Top Stats Row --}}
    <div class="row">
        
        {{-- Sales Value Card --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow" style="background-color: #fac0b9">
                <div class="card-header d-sm-flex flex-row align-items-center flex-0">
                    <div class="d-block mb-3 mb-sm-0">
                        <div class="fs-5 fw-normal mb-2">Sales Value</div>
                        <h2 class="fs-3 fw-extrabold">$10,567</h2>
                        <div class="small mt-2">
                            <span class="fw-normal me-2">Yesterday</span>
                            <x-icon name="arrowUp" class="text-success" />
                            <span class="text-success fw-bold">10.57%</span>
                        </div>
                    </div>
                    <div class="d-flex ms-auto">
                        <a href="#" class="btn btn-secondary btn-sm me-2">Month</a>
                        <a href="#" class="btn btn-sm me-3">Week</a>
                    </div>
                </div>
                <div class="card-body p-2">
                    {{-- Chart container --}}
                    <div class="ct-chart-sales-value ct-double-octave ct-series-g"></div>
                </div>
            </div>
        </div>

        {{-- Customers Card --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                <x-icon name="users" size="lg" />
                            </div>
                            <div class="d-sm-none">
                                <h2 class="h5">Customers</h2>
                                <h3 class="fw-extrabold mb-1">345,678</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Customers</h2>
                                <h3 class="fw-extrabold mb-2">345k</h3>
                            </div>
                            <small class="d-flex align-items-center text-gray-500">
                                Feb 1 - Apr 1,
                                <x-icon name="globe" class="icon-xxs text-gray-500 ms-2 me-1" />
                                USA
                            </small>
                            <div class="small d-flex mt-1">
                                <div>Since last month 
                                    <x-icon name="arrowUp" class="icon-xs text-success" />
                                    <span class="text-success fw-bolder">22%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Revenue Card --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-secondary rounded me-4 me-sm-0">
                                <x-icon name="money" size="lg" />
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5">Revenue</h2>
                                <h3 class="mb-1">$43,594</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Revenue</h2>
                                <h3 class="fw-extrabold mb-2">$43,594</h3>
                            </div>
                            <small class="text-gray-500">
                                Feb 1 - Apr 1,
                                <x-icon name="globe" class="icon-xxs text-gray-500 ms-2 me-1" />
                                GER
                            </small>
                            <div class="small d-flex mt-1">
                                <div>Since last month 
                                    <x-icon name="arrowDown" class="icon-xs text-danger" />
                                    <span class="text-danger fw-bolder">2%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bounce Rate Card --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                <x-icon name="chartLine" size="lg" />
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5">Bounce Rate</h2>
                                <h3 class="mb-1">50.88%</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Bounce Rate</h2>
                                <h3 class="fw-extrabold mb-2">50.88%</h3>
                            </div>
                            <small class="text-gray-500">
                                Feb 1 - Apr 1
                            </small>
                            <div class="small d-flex mt-1">
                                <div>Since last month 
                                    <x-icon name="arrowUp" class="icon-xs text-success" />
                                    <span class="text-success fw-bolder">4%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Middle Section: Tables and Lists --}}
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="row">
                {{-- Page Visits Table --}}
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="fs-5 fw-bold mb-0">Page visits</h2>
                                </div>
                                <div class="col text-end">
                                    <a href="#" class="btn btn-sm btn-primary">See all</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-bottom" scope="col">Page name</th>
                                        <th class="border-bottom" scope="col">Page Views</th>
                                        <th class="border-bottom" scope="col">Page Value</th>
                                        <th class="border-bottom" scope="col">Bounce rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-gray-900" scope="row">/demo/admin/index.html</th>
                                        <td class="fw-bolder text-gray-500">3,225</td>
                                        <td class="fw-bolder text-gray-500">$20</td>
                                        <td class="fw-bolder text-gray-500">
                                            <div class="d-flex">
                                                <x-icon name="arrowUp" class="icon-xs text-danger me-2" />
                                                42,55%
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Team Members List --}}
                <div class="col-12 col-xxl-6 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                            <h2 class="fs-5 fw-bold mb-0">Team members</h2>
                            <a href="#" class="btn btn-sm btn-primary">See all</a>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush list my--3">
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <a href="#" class="avatar">
                                                <img class="rounded" alt="Image placeholder" src="{{ asset('assets/img/team/profile-picture-1.jpg') }}">
                                            </a>
                                        </div>
                                        <div class="col-auto ms--2">
                                            <h4 class="h6 mb-0"><a href="#">Chris Wood</a></h4>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success dot rounded-circle me-1"></div>
                                                <small>Online</small>
                                            </div>
                                        </div>
                                        <div class="col text-end">
                                            <a href="#" class="btn btn-sm btn-secondary d-inline-flex align-items-center">
                                                <x-icon name="userPlus" class="icon-xxs me-2" />
                                                Invite
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                </ul>
                        </div>
                    </div>
                </div>

                {{-- Progress Track --}}
                <div class="col-12 col-xxl-6 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                            <h2 class="fs-5 fw-bold mb-0">Progress track</h2>
                            <a href="#" class="btn btn-sm btn-primary">See tasks</a>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-auto">
                                    <x-icon name="file" class="icon-sm text-gray-500" />
                                </div>
                                <div class="col">
                                    <div class="progress-wrapper">
                                        <div class="progress-info">
                                            <div class="h6 mb-0">Rocket - SaaS Template</div>
                                            <div class="small fw-bold text-gray-500"><span>75 %</span></div>
                                        </div>
                                        <div class="progress mb-0">
                                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Right Column: Total Orders, Ranking, Acquisition --}}
        <div class="col-12 col-xl-4">
            {{-- Total Orders Chart --}}
            <div class="col-12 px-0 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                        <div class="d-block">
                            <div class="h6 fw-normal text-gray mb-2">Total orders</div>
                            <h2 class="h3 fw-extrabold">452</h2>
                            <div class="small mt-2">
                                <x-icon name="arrowUp" class="text-success" />
                                <span class="text-success fw-bold">18.2%</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <div class="ct-chart-ranking ct-golden-section ct-series-a"></div>
                    </div>
                </div>
            </div>

            {{-- Global & Country Rank --}}
            <div class="col-12 px-0 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between border-bottom pb-3">
                            <div class="d-flex align-items-center">
                                <x-icon name="globe" class="icon-xs text-gray-500 me-2" />
                                <span>Global Rank</span>
                            </div>
                            <div>
                                <a href="#" class="d-flex align-items-center fw-bold">
                                    #755
                                    <x-icon name="arrowUp" class="icon-xs text-gray-500 ms-1" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Acquisition --}}
            <div class="col-12 px-0">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h2 class="fs-5 fw-bold mb-1">Acquisition</h2>
                        <p>Tells you where your visitors originated from, such as search engines, social networks or website referrals.</p>
                        <div class="d-block">
                            <div class="d-flex align-items-center me-5">
                                <div class="icon-shape icon-sm icon-shape-danger rounded me-3">
                                    <x-icon name="chartBar" />
                                </div>
                                <div class="d-block">
                                    <label class="mb-0">Bounce Rate</label>
                                    <h4 class="mb-0">33.50%</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>