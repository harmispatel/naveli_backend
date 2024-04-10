$('.clearButton').on('click', function()
{
    $("#searchInput").val(null);
    $("#searchInputSong").val(null);
    $("#searchInputCountry").val(null);
    getRadioAirPlayList('', '');
    getRadioAirPlaySongList('', '');
    getairplayByCountryList('', '');
})

// $(".searchButton").on('click', function()
// {
//     var search = $('#searchInPput').val();
//     getSongLabels('','',search);
//     getRadioAirPlayList('', search);
//     getPlayList('',search);
// })

function exportradioairplaysong(id,url)
{
    var filterLastDays = $('#filter_last_days :selected').val();
    var customsearch = $('#searchInputSong').val();

     // Get the CSRF token from the meta tag
     var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        "url": url,
        "type": 'POST',
        "data": {
            '_token': csrfToken,
            'id': id,
            'last_day_filter': filterLastDays,
            'customesearch': customsearch,
        },
        success: function(response) {
            var blob = new Blob([response], {
                type: 'text/csv'
            });
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'exported_airplayby_song.csv';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        },
        error: function(error) {
            // Handle errors
            console.log(error);
        }
    });
}


function exportbycountrysong(id,url) {

    var airplayCountrySongsDay = $('#filter_aircountry_songs :selected').val();
    var customesearch = $('#searchInputCountry').val();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        "url":url,
        "type": 'POST',
        "data": {
            '_token': csrfToken,
            'id': id,
            'airplayCountrySongsDay': airplayCountrySongsDay,
            'customesearch': customesearch,
        },
        success: function(response) {
            var blob = new Blob([response], {
                type: 'text/csv'
            });
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'exported_airplayby_country.csv';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        },
        error: function(error) {
            // Handle errors
            console.log(error);
        }
    });
}


function exportsong(id, songs, url) {
    var airplaySongsDay = $('#filter_airplay_songs :selected').val();
    var customesearch = $('#searchInput').val();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        "url":url,
        "type": 'POST',
        "data": {
            '_token':csrfToken,
            'id': id,
            'songs': songs,
            'airplaySongsDay': airplaySongsDay,
            'customesearch': customesearch,
        },
        success: function(response) {
            var blob = new Blob([response], {
                type: 'text/csv'
            });
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'exported_song_list.csv';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        },
        error: function(error) {
            console.log(error);
        }
    });
}


// function customFilter()
// {
//     const lastDayFilter = $('#filter_last_days :selected').val();
//     getRadioAirPlaySongList(lastDayFilter, '');
// }
