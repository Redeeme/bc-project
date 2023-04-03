@extends('layouts.app')
@section('pageTitle', 'gantt')
@section('content')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-text" id="exampleModalText1">Text</h5>
                    <h5 class="modal-text" id="exampleModalText2">Text</h5>
                    <h5 class="modal-text" id="exampleModalText3">Text</h5>
                    <h5 class="modal-text" id="exampleModalText4">Text</h5>
                    <h5 class="modal-text" id="exampleModalText5">Text</h5>
                    <h5 class="modal-text" id="exampleModalText6">Text</h5>
                </div>
                <div id="map"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js"></script>

    <script>
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
            key: "AIzaSyA-JzM07gPSTvahW9P2UWLzaeUtEItsx8Q",
            // Add other bootstrap parameters as needed, using camel case.
            // Use the 'v' parameter to indicate the version to load (alpha, beta, weekly, etc.)
        });
    </script>

    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
    <script>
        // let processes = [{"label":"2","id":"2"},
        //     {"label":"3","id":"3"},
        //     {"label":"33","id":"33"},
        //     {"label":"34","id":"34"},
        //     {"label":"4","id":"4"}]
        //
        // let task = [{"processid":"2","start":"05:57:00","end":"05:21:00","label":"92 160 2022-11-18 05:57:00 2022-11-18 05:21:00 10.486 11.0"},
        //     {"processid":"3","start":"05:23:00","end":"06:12:00","label":"160 160 2022-11-18 05:23:00 2022-11-18 06:12:00 19.565 21.0"},
        //     {"processid":"33","start":"05:26:00","end":"06:50:00","label":"92 160 2022-11-18 05:26:00 2022-11-18 06:50:00 10.486 11.0"},
        //     {"processid":"34","start":"06:03:00","end":"07:52:00","label":"160 160 2022-11-18 06:03:00 2022-11-18 07:52:00 19.565 21.0"},
        //     {"processid":"4","start":"07:33:00","end":"07:22:00","label":"160 160 2022-11-18 07:33:00 2022-11-18 07:22:00 19.565 21.0"}]

        let array_process = @json($processes);
        let array_task = @json($task);
        let array_categories = @json($categories);
        let array_category = @json($category);
        let palette = Math.floor(Math.random() * 5);
        let tourNumber = @json($tour);
        let dataset = @json($dataset);
        let chargers = @json($chargers);

        let paneLength = 0;
        if (array_process.length > 550){
            paneLength = 6;
        }else if(array_process.length > 400){
            paneLength = 8;
        }else if(array_process.length > 120){
            paneLength = 14;
        }else if(array_process.length > 50) {
            paneLength = 16;
        }else{
            paneLength = 20;
        }
        function titleLabel() {
            if (array_task[0].schedule_index != null){
                return ("Rozvrh číslo: " + tourNumber + "\t\tNazov suboru: " + dataset);
            }else if(array_task[0].taskid != null){
                return  ("Turnus číslo: " + tourNumber + "\t\tNazov suboru: " + dataset);
            }else if(array_task[0].charger_task_id != null){
                return  ("Nabijacka číslo: " + tourNumber + "\t\tNazov suboru: " + dataset);
            }
        }

        async function initMap(lat, lng) {
            //@ts-ignore
            const { Map } = await google.maps.importLibrary("maps");

            map = new Map(document.getElementById("map"), {
                center: { lat: lat, lng: lng },
                zoom: 16,
            });
            var mapp = document.getElementById("map");
            mapp.style.display = "block";
            var marker = new google.maps.Marker({
                position: { lat: lat, lng: lng },
                map: map
            });
        }
        function toggleVisibility() {
            $("#exampleModalText6").text(``);
            var map = document.getElementById("map");
            map.style.display = "none";
        }

        const dataSource = {
            tasks: {
                showlabels: "0",
                fontsize: "30",
                task: array_task
            },
            processes: {
                fontsize: "20",
                isbold: "1",
                align: "Center",
                headertext: "Spoje",
                headerfontsize: "14",
                headervalign: "middle",
                headeralign: "left",
                process: array_process
            },
            categories: [
                {

                    category: [
                        {
                            start: array_category[0].start,
                            end: array_category[0].end,
                            label: array_category[0].label
                        }
                    ]
                },
                {
                    fontsize: "25",
                    align: "center",
                    category: array_categories
                }
            ],

            chart: {
                dateformat: "dd/mm/yyyy",
                outputdateformat: "hh12:mn ampm",
                width: "500",
                height: "300",
                caption: titleLabel(),
                ganttpaneduration: paneLength,
                ganttpanedurationunit: "h",
                useverticalscrolling: "1",
                theme: "fusion",
                palette: palette
            }
        };

        FusionCharts.ready(function () {
            var myChart = new FusionCharts({
                type: "gantt",

                renderAt: "chart-container",
                width: '94%',
                height: '83%',
                dataFormat: "json",
                dataSource,
                events: {

                    /**
                     * @description
                     * The processClick event is triggered when a process in the Gantt chart is clicked. *
                     * @param {Object} eventObj: An object containing all the details related to this event like eventId, sender, etc.
                     * @param {Object} dataObj: An object containing all the details related to the process being clicked, such as its label, information about whether it is a header or no, and so on.
                     */

                    processClick: function (eventObj, dataObj) {

                        array_task.forEach((element) => {

                            if (element.schedule_index === eventObj.data.id && element.schedule_index != null){
                                @if(isset($type))
                                    let type = @json($type);
                                @endif
                                $('#exampleModal').modal('show');
                                $("#exampleModalLabel").text(`id: ${eventObj.data.id}`);
                                $("#exampleModalText1").text(`start: ${element.start}`);
                                $("#exampleModalText2").text(`end: ${element.end}`);
                                $("#exampleModalText3").text(`energy_before: ${element.energy_before}`);
                                $("#exampleModalText4").text(`energy_after: ${element.energy_after}`);
                                $("#exampleModalText5").text(`consumption: ${element.consumption}`);
                                    if (element.charger_index != null){
                                        $("#exampleModalText6").text(`charger index: ${element.charger_index}`);
                                        for (let i = 0; i < chargers.length; i++) {

                                            if (chargers[i].charger_index === element.charger_index) {
                                                console.log('lol '+element.charger_index,element.schedule_index);
                                                initMap(chargers[i].lat,chargers[i].long)
                                                break
                                            }
                                        }
                                    }else{
                                        toggleVisibility();
                                    }

                            }else if(element.task_id === eventObj.data.id && element.task_id != null){
                                $('#exampleModal').modal('show');
                                $("#exampleModalLabel").text(`id: ${eventObj.data.id}`);
                                $("#exampleModalText1").text(`start: ${element.start}, end: ${element.end}`);
                                $("#exampleModalText2").text(`loc_start: ${element.loc_start}, loc_end: ${element.loc_end}`);
                                $("#exampleModalText3").text(`distance: ${element.distance}`);
                                $("#exampleModalText4").text(`consumption: ${element.consumption}`);
                                $("#exampleModalText5").text(`linka: ${element.linka}`);
                                toggleVisibility();
                            }else if(element.process_id === eventObj.data.id && element.charger_task_id != null){
                                $('#exampleModal').modal('show');
                                $("#exampleModalLabel").text(`id: ${eventObj.data.id}`);
                                $("#exampleModalText1").text(`start: ${element.start}, end: ${element.end}`);
                                $("#exampleModalText2").text(`loc: ${element.loc}`);
                                $("#exampleModalText3").text(`speed: ${element.speed}`);
                                $("#exampleModalText4").text(`charger_task_id: ${element.charger_task_id}`);
                                $("#exampleModalText6").text(``);
                                if (element.charger_id != null){
                                    $("#exampleModalText6").text(`charger index: ${element.charger_id}`);
                                    for (let i = 0; i < chargers.length; i++) {

                                        if (chargers[i].charger_index === element.charger_id) {
                                            console.log('lol '+chargers[i].lat,chargers[i].long);
                                            initMap(chargers[i].lat,chargers[i].long)
                                            break
                                        }
                                    }
                                }else{
                                    toggleVisibility();
                                }
                            }
                        })
                    }
                }

            }).render();
            myChart.setJSONData(dataSource);
        });

    </script>
    @if(isset($tourFlag))
        <div class="card text-center" style="width: 94%; margin-left: 3%">
            <div class="card-header" >
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('gantt-tour')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $tourFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">schema gantt</button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('page-data-table')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $tourFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">tabulkove zobrazenie</button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px; display: none;">
                        <form action="{{route('stats-tour')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $tourFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">statistiky dat</button>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    @endif
    @if(isset($chargerFlag))
        <div class="card text-center" style="width: 94%; margin-left: 3%">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('gantt-charger')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $chargerFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">schema gantt</button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('page-data-table')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $chargerFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">tabulkove zobrazenie</button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px; display: none;">
                        <form action="{{route('stats-charger')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $chargerFlag }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">statistiky dat</button>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    @endif
    @if(isset($scheduleFlag))
        <div class="card text-center" style="width: 94%; margin-left: 3%">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('gantt-schedule')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $scheduleFlag }}">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">schema gantt</button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('page-data-table')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $scheduleFlag }}">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">tabulkove zobrazenie</button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item" style="margin-right: 5px">
                        <form action="{{route('stats-schedule')}}" method="post">
                            @csrf
                            <input type="hidden" name="data" value="{{ $scheduleFlag }}">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <input type="hidden" name="dataset" value="{{ $dataset }}">
                            <input type="hidden" name="name" value="{{ $name }}">
                            <div class="form group">
                                <button type="submit" class="btn btn-primary btn-block" id="update_button">statistiky dat</button>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    @endif
    <div class="card-body align-items-center d-flex justify-content-center" STYLE="margin-top: 20px">
        <div id="chart-container"></div>
    </div>


@endsection
