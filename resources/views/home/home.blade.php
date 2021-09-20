@extends('layouts.app')

@section('content')
               <!-- CONTENT -->
               <div class="ui center aligned container">
                    <form class="ui form">
                         <div class="inline field">
                              <label>Megye</label>
                              <div class="ui selection dropdown" id="counties">
                              <input type="hidden" name="county">
                              <i class="dropdown icon"></i>
                              <div class="default text">Válasszon</div>
                              <div class="menu">
@foreach ($countiesArray as $county)
                                   <div class="item" data-value="{{ $county->id }}" data-text="{{ $county->name }}">{{ $county->name }}</div>
@endforeach
                              </div>
                              </div>

                         </div>
                    </form>
               </div>
               <div class="ui text container tertiary olive inverted segment" id="addCityDiv">
                    <form class="ui form" id="addCity">
                         <div class="inline field">
                              <label>Új város:</label>
                              <div class="ui fluid action input">
                                   <input type="text" placeholder="új város neve" id="newCity">
                                   <button class="ui green button">felvesz</button>
                              </div>
                         </div>
                    </form>
               </div>

               <div id="cities">
                    <table class="ui striped table" id="citiesTable">
                         <thead>
                              <tr>
                                   <th><span id="selectedCountyName"></span> megye városai</th>
                              </tr>
                         </thead>
                         <tbody>
                              <tr><td></td></tr>
                         </tbody>
                    </table>

               </div>
               <!-- /CONTENT -->
@endsection

@section('scripts')
          <!-- PAGE SCRIPTS -->
          <script>
               var isItClickable = true;
               var selectedCityId;
               var selectedCityName;
               $(document).ready( function(){
                    // initialize the site
                    $('#counties').dropdown();
                    $('#addCityDiv').hide();
                    $('#cities').hide();

                    // run if a county has selected
                    $('#counties').change( function(){
                         $('#addCityDiv').show();
                         $('#cities').show();
                         $('#selectedCountyName').text( $('#counties').dropdown('get text') );
                         tableUpdater();
                         isItClickable = true;
                    })

                    // run if the user wants to add a new city
                    $('#addCity').submit( function( event ){
                         event.preventDefault();

                         $.ajax({
                              type: 'POST',
                              dataType: 'json',
                              url: 'city',
                              headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              },
                              data: {
                                   county: $('#counties').dropdown('get value'),
                                   city: $('#newCity').val()
                              },
                              success: function( msg ) {
                                   console.log('> success ajax insertion: ' + msg.status);
                                   tableUpdater();
                              },
                              error: function( msg ) {
                                   console.error('> something wrong happened during insertion: ' );
                                   console.error( msg );
                              }
                         })
                         $('#newCity').val('');
                    })

                    $("#cities").on('click', 'table tbody tr', function(){
                         if( isItClickable ){
                              selectedCityName = $(this).children().children('span').text();
                              selectedCityId = $(this).children().children(':input').val();
                              $(this).children().children().remove();
                              $(this).children().append("<div class='ui fluid input' id='city-" + selectedCityId + "-input'><input type='text' value='" + selectedCityName + "' id='editCityNameInput'><button class='circular ui green icon button' onclick='editCity()'><i class='check icon'></i></button><button class='circular ui red icon button' onclick='deleteCity()'><i class='x icon icon'></i></button><button class='circular ui yellow icon button' onclick='cityNameEditorRemove()'><i class='undo icon'></i></button></div>");
                              isItClickable = false;
                         }
                    })
               });

               // run if the user wants to edit a city
               function editCity()
               {
                    $.ajax({
                         type: 'PUT',
                         dataType: 'json',
                         url: 'city',
                         headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
                         data: {
                              cityId: selectedCityId,
                              cityName: $('#editCityNameInput').val()
                         },
                         success: function( msg ) {
                              console.log('> success ajax edition: ' + msg.status);
                              tableUpdater();
                         },
                         error: function( msg ) {
                              console.error('> something wrong happened during insertion: ' );
                              console.error( msg );
                         }
                    })
                    cityNameEditorRemove();
               }

               // run if the user wants to delete a city
               function deleteCity()
               {
                    $.ajax({
                         type: 'DELETE',
                         dataType: 'json',
                         url: 'city',
                         headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
                         data: {
                              cityId: selectedCityId
                         },
                         success: function( msg ) {
                              console.log('> success ajax deletion: ' + msg.status);
                              tableUpdater();
                         },
                         error: function( msg ) {
                              console.error('> something wrong happened during insertion: ' );
                              console.error( msg );
                         }
                    })
                    cityNameEditorRemove();
               }

               // list of cities updater function
               function tableUpdater()
               {
                    $('#citiesTable tbody').find('tr').each( function(){
                         $(this).remove();
                    });
                    $.ajax({
                         type: 'GET',
                         dataType: 'json',
                         url: 'getcities/' + $('#counties').dropdown('get value'),
                         success: function( msg ) {
                              console.log( '> success ajax responde');
                              msg.cities.forEach(element => {
                                   let newRow = "<tr><td><span id='city-" + element.id + "'>" + element.name + "</span><input type='hidden' value='" + element.id + "'></td></tr>";
                                   $('#citiesTable tbody').append( newRow );
                              });
                         },
                         error: function( msg ) {
                              console.error( '> something wrong happened during getting data: ' );
                              console.error( data );
                         }
                    });
               }

               $( document ).on('keydown', function(event){
                    if (event.key == "Escape") {
                         cityNameEditorRemove();
                    }
               });

               function cityNameEditorRemove()
               {
                    let newRow = "<span id='city-" + selectedCityId + "'>" + selectedCityName + "</span><input type='hidden' value='" + selectedCityId + "'>";
                    $('#city-' + selectedCityId + '-input').parent().append( newRow );
                    $('#city-' + selectedCityId + '-input').remove();
                    isItClickable = true;
               }
          </script>
          <!-- /PAGE SCRIPTS -->
@endsection

@section('footer')
          <!-- FOOTER -->
          <footer>{{ config('app.name') }} {{ config('app.version') }} <i class='heart outline icon'></i> Laravel {{ Illuminate\Foundation\Application::VERSION }}</strong> (PHP {{ PHP_VERSION }})</footer>
          <!-- /FOOTER -->
@endsection