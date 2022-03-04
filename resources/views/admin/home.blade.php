<x-app-layout>
    
    </x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" >
    <title>DentalClinic</title>
    
    <!--font awesome cdn link-->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!--custom css file link-->
   <link rel = "stylesheet" href = "admin/assets/css/style.css">
</head>
<body>
        <input type ="checkbox" id="nav-toggle">
        <div class="sidebar">
            <div class = "sidebar-brand">
                <h2><span class="fas fa-tooth"></span> <span>DentalClinic</span></h2>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="admin/html/index.html" class="active"><span class = "fas fa-home"></span>
                            <span>Pagrindinis</span></a>
                    </li>

                    <li>
                        <a href="admin/html/patients.html"><span class = "fas fa-users"></span>
                            <span>Pacientai</span></a>
                    </li>

                    <li>
                        <a href="admin/html/doctors.html"><span class = "fas fa-user-md"></span>
                            <span>Daktarai</span></a>
                    </li>

                    <li>
                        <a href="admin/html/appointments.html"><span class = "fas fa-calendar-check"></span>
                            <span>Vizitai</span></a>
                    </li>

                    <li>
                        <a href="admin/htmlschedule.html"><span class = "fas fa-calendar-alt"></span>
                            <span>Tvarkaraštis</span></a>
                    </li>

                    <li>
                        <a href="admin/html/procedures.html"><span class = "fas fa-hand-holding-medical"></span>
                            <span>Procedūros</span></a>
                    </li>

                    <li>
                        <a href="admin/html/currentuser.html"><span class = "fas fa-user-cog"></span>
                            <span>Paskyra</span></a>
                    </li>
                </ul> 
            </div>
        </div>
        <div class="main-content">
          
      <header>
                <h2>
                    <label for="nav-toggle">
                        <span class = "fas fa-bars"></span>
                    </label>

                    Pagrindinis
                </h2>
                <div class = "search-wrapper">
                    <span class = "fas fa-search"></span>
                    <input type = "search" placeholder="Įveskite raktažodį"/>
                </div>

                <div class ="user-wrapper">
                    <img src="admin/assets/images/image.jpg" width="35px" height="40px" alt="">
                        <div>
                            <h4> Agne Jonaitiene</h4>
                            <small>Administratorius</small>

                        </div>
                </div>
            </header>
            <main>
                <div class = "cards">
                    <div class = "card-single">
                        <h1>54</h1>
                        <span>Pacientai</span>
                        <div> 
                            <span class ="fas fa-users"></span>
                        </div>
                    </div>
                    <div class = "card-single">
                        <h1>54</h1>
                        <span>Daktarai</span>
                        <div> 
                            <span class ="fas fa-user-md"></span>
                        </div>
                    </div>
                    <div class = "card-single">
                        <h1>14</h1>
                        <span>Vizitai šiandien</span>
                        <div> 
                            <span class ="fas fa-calendar-check"></span>
                        </div>
                    </div>
                    <div class = "card-single">
                        <h1>154</h1>
                        <span>Vizitai šį mėnesį</span>
                        <div> 
                            <span class ="fas fa-calendar-check"></span>
                        </div>
                    </div>
                </div>

                <div class = "recent-grid">
                    <div class="appointments">
                        <div class = "card">
                            <div class="card-header">
                                <h3>
                                    Vizitų registracija
                                </h3>
                             
                                <button> <a href = "appointments.html"> Pamatyti visus <span class="fas fa-chevron-right"></span></a></button>
    
                            </div>
                            <div class="card-body">
                               <div class="table-responsive">
                                <table width = "100%">
                                    <thead>
                                        <tr>
                                            <td> Vizito ID </td>
                                            <td> Pacientas </td>
                                            <td> Būsena </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>V01</td>
                                            <td>Petras Petraitis</td>
                                            <td>
                                                <span class = "status green"></span>patvirtinta</td>
                                        </tr> 
                                        <tr>
                                            <td>V01</td>
                                            <td>Petras Petraitis</td>
                                            <td>
                                                <span class="status yellow"></span>laukiama</td>
                                        </tr>
                                        <tr>
                                            <td>V01</td>
                                            <td>Petras Petraitis</td>
                                            <td>
                                                <span class="status red"></span>atšaukta</td>
                                        </tr>
                                        <tr>
                                            <td>V01</td>
                                            <td>Petras Petraitis</td>
                                            <td>
                                                <span class="status grey"></span>įvykdyta</td>
                                        </tr>
                                    </tbody>
                                </table>
                               </div>
                          </div>
                    </div>
                </div>
                       
                <div class="patients">
                    <div class = "card">
                        <div class="card-header">
                            <h3> Nauji pacientai </h3>
                            <button> <a href = "patients.html">Pamatyti visus <span class = "fas fa-chevron-right"></span></a></button>
                        </div>
                        <div class="card-body">
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                            <div class="patient">
                                <div class ="info">
                                    <h4>P01</h4>
                                    <h4>Pacientas1 Pacientas2</h4>
                                    <small><span><i class = "fas fa-envelope"></i></span>patient@gmail.com</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>


    <!-- custom js file link-->
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
