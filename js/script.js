$(document).ready(() => {

    // toont live gegevens op de webpagina met behulp van AJAX.
    // Timeout toegevoegd voor beter userexperience & belast de server minder.
    let timeOut = null;
    $('#search-athletes').keyup(() => {
        clearTimeout(timeOut);
        timeout = setTimeout(() => {
            searchAthletes();
        }, 500);
    });

    $('#btn-send-athlete-data').on('click', () => {
        editAthlete();
    });
});

let athletesData;

function searchAthletes() {
    let userInputSearchAthlete = $('#search-athletes').val();
    if (userInputSearchAthlete == '') {
        $('#result-athlete-data').html(''); // Toont geen data op de webpagina wanneer userInputSearchAthlete leeg is.
        return;
    }
    // Toont de data bij elke keystroke met een timeout van 500 miliseconden.
    $.ajax({
            dataType: "json",
            url: "../includes/fetchAthleteData.php",
            method: "POST",
            data: {
                searchAthlete: userInputSearchAthlete
            }
        })
        .done((dataAthletes) => {
            athletesData = dataAthletes;

            // data {id, name_athlete, info_athlete}[]
            let tableRows = "";
            if (athletesData.length == 0) {
                tableRows = `
                <tr class="row athlete-data">
                    <td class="col-sm-12" colspan="2">Athlete not found.</td>
                <tr>
            `;
            } else {
                for (let athlete of athletesData) {
                    var editButton = "";
                    // gebruiker is ingelogd, toon editButton
                    if (isLoggedIn) {
                        editButton = `<br><br><button type="button" class="btn btn-warning" onclick="openEditAthlete(${athlete.id})">Edit</button>`;
                    }
                    tableRows += `
                    <tr class="row athlete-data">
                        <td class="col-sm-12 col-md-3">${athlete.name_athlete}</td>
                        <td class="col-sm-12 col-md-9">
                            ${athlete.info_athlete}
                            ${editButton}
                        </td>
                    </tr>`;
                }
            }
            // toon data op de index.php pagina
            $('#result-athlete-data').html(tableRows);
        });
}

function openEditAthlete(athleteId) {
    // check welke id overeenkomt met het column waarin geklickt is en stopt die object in var athlete
    var athlete = athletesData.find(idAthlete => idAthlete.id == athleteId);

    $('#athlete-edit-id-input').val(athlete.id);
    $('#athlete-edit-name-input').val(athlete.name_athlete);
    $('#athlete-edit-info-input').val(athlete.info_athlete);

    $('#change-athlete-content').modal('show');
}

// functie waarbij de data uit de inputs word opgehaald en terug gestuurd via AJAX call naar updateAthleteData.php,
// die het vervolgens weer naar de database stuurt
function editAthlete() {
    let athleteChangedId = $('#athlete-edit-id-input').val();
    let athleteChangedName = $('#athlete-edit-name-input').val();
    let athleteChangedInfo = $('#athlete-edit-info-input').val();

    $.ajax({
            url: "../includes/updateAthleteData.php",
            method: "POST",
            data: {
                athleteId: athleteChangedId,
                athleteName: athleteChangedName,
                athleteInfo: athleteChangedInfo
            }
        })
        .done(() => {
            searchAthletes();
            $('#change-athlete-content').modal('hide');
        });
}