@extends('layouts.admin')

@section('title', 'Admin Home Page')
@section('headingTitle', 'Pagrindinis')

@section('content')

<div class="cards">
    <div class="card-single">
        <h1>54</h1>
        <span>Pacientai</span>
        <div>
            <span class="fas fa-users"></span>
        </div>
    </div>
    <div class="card-single">
        <h1>54</h1>
        <span>Daktarai</span>
        <div>
            <span class="fas fa-user-md"></span>
        </div>
    </div>
    <div class="card-single">
        <h1>14</h1>
        <span>Vizitai šiandien</span>
        <div>
            <span class="fas fa-calendar-check"></span>
        </div>
    </div>
    <div class="card-single">
        <h1>154</h1>
        <span>Vizitai šį mėnesį</span>
        <div>
            <span class="fas fa-calendar-check"></span>
        </div>
    </div>
</div>

<div class="recent-grid">
    <div class="appointments">
        <div class="card">
            <div class="card-header">
                <h3>
                    Vizitų registracija
                </h3>

                <button> <a class="text-reset text-decoration-none" href="appointments.html"> Pamatyti visus <span class="fas fa-chevron-right"></span></a></button>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table width="100%">
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
                                    <span class="status green"></span>patvirtinta
                                </td>
                            </tr>
                            <tr>
                                <td>V01</td>
                                <td>Petras Petraitis</td>
                                <td>
                                    <span class="status yellow"></span>laukiama
                                </td>
                            </tr>
                            <tr>
                                <td>V01</td>
                                <td>Petras Petraitis</td>
                                <td>
                                    <span class="status red"></span>atšaukta
                                </td>
                            </tr>
                            <tr>
                                <td>V01</td>
                                <td>Petras Petraitis</td>
                                <td>
                                    <span class="status grey"></span>įvykdyta
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="patients">
        <div class="card">
            <div class="card-header">
                <h3> Nauji pacientai </h3>
                <button> <a class="text-reset text-decoration-none" href="patients.html">Pamatyti visus <span class="fas fa-chevron-right"></span></a></button>
            </div>
            <div class="card-body">
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
                <div class="patient">
                    <div class="info">
                        <h4>P01</h4>
                        <h4>Pacientas1 Pacientas2</h4>
                        <small><span><i class="fas fa-envelope"></i></span>patient@gmail.com</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection