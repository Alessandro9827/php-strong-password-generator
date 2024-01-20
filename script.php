<?php
// apri session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['password_length'])) {
    // Chiedo la lunghezza della password
    $password_length = $_GET['password_length'];



    // $cryptedPassword = genera una nuova password 
    $_SESSION['cryptedPassword'] = createRandomPassword($password_length, isset($_GET['letters']), isset($_GET['numbers']), isset($_GET['symbols']));
} else {
    echo 'there was some problems with the request :(';
};


// Generara una password in modo casuale
function createRandomPassword($length, $includeLetters, $includeNumbers, $includeSymbols)
{
    $length = (int)$length;

    $characters = '';

    // Combina caratteri, numeri, simboli per generare la password
    if ($includeLetters) {
        $characters .= 'abcdefghilmnopqrstuvzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    };

    if ($includeNumbers) {
        $characters .= '0123456789';
    };

    if ($includeSymbols) {
        $characters .= '+"*&/(=!){]}[.,-;:_\~';
    };

    // abilita ripetizione dei caratteri
    $allowRepetition = isset($_GET['caharacter-repetition']) && $_GET['character-repetition'] === 'yes';

    // shuffle dei caratteri
    $shuffle_characters = str_shuffle($characters);

    // return il risultato -> nuova password criptata della stessa lunghezza
    return substr($shuffle_characters, 0, $length);
};


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Strong Password Generator</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- css -->
    <link rel="stylesheet" href="./css/style.css">

</head>

<body>

    <main>
        <section class="container-fluid">
            <div class="row">
                <h1 class="text-light text-center">Strong Password Generator</h1>
                <h2 class="text-light fs-3 text-center mb-5">Generate a strong, secure, awesome, beautiful and clean
                    password.
                </h2>
                <form class="col-10 offset-1 bg-light p-3 rounded" method="GET" action="">
                    <div class="mb-3">
                        <label for="password-length" class="form-label">Password length</label>
                        <input type="number" class="form-control" id="password-length" name="password_length" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="letters" name="letters" checked>
                        <label class="form-check-label" for="letters">Letters</label>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="numbers" name="numbers">
                        <label class="form-check-label" for="numbers">Numbers</label>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="symbols" name="symbols">
                        <label class="form-check-label" for="symbols">Symbols</label>
                    </div>

                    <div class="row mb-3">
                        <p>Allow repetition of characters: </p>
                        <div class="form-check ms-2">
                            <input class="form-check-input" type="radio" name="character-repetition" value="yes" id="character-repetition-yes" checked>
                            <label class="form-check-label" for="character-repetition-yes">
                                Yes
                            </label>
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input" type="radio" name="character-repetition" value="no" id="character-repetition-no">
                            <label class="form-check-label" for="character-repetition-no">
                                No
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <div class="col-10 offset-1 mt-3 bg-light py-2 rounded">
                    <p class="mb-0">New
                        Password: <?php echo isset($_SESSION['cryptedPassword']) ? $_SESSION['cryptedPassword'] : ''; ?>
                    </p>
                </div>
            </div>
        </section>
    </main>
</body>

</html>