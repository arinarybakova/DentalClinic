@extends('layouts.admin')

@section('title', 'Procedures')

@section('content')

    <procedure-table></procedure-table>
<div class="search">
    <form class="search-form">
        <input type="text" placeholder="Įveskite paieškos raktažodį">
        <input type="submit" value="Ieškoti">
    </form>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="ptable" width="100%">
            <thead>
                <td> ID </td>
                <td> Pavadinimas</td>
                <td> Kaina</a> </td>
                <td> Aprašymas </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>P001</td>
                    <td>Pavadinimas1</td>
                    <td><a href="patientview.html">Pacientas1 Pacientas2</td>
                    <td><a href="doctorview.html">Daktaras1 Daktaras2</td>
                </tr>
                <tr>
                    <td>P002</td>
                    <td>Pavadinimas1</td>
                    <td>Pacientas1 Pacientas2</td>
                    <td>Daktaras1 Daktaras2</td>
                </tr>
                <tr>
                    <td>P003</td>
                    <td>Pavadinimas1</td>
                    <td>Pacientas1 Pacientas2</td>
                    <td>Daktaras1 Daktaras2</td>
                </tr>
                <tr>
                    <td>P004</td>
                    <td>Pavadinimas1</td>
                    <td>Pacientas1 Pacientas2</td>
                    <td>Daktaras1 Daktaras2</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection