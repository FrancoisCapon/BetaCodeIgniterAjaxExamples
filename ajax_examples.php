<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ajax Examples - CodeIgniter</title>
    <link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-default.min.css">

    <style>
        :root {
            --fc-primary: #1976d2;
        }

        button.primary,
        [type="button"].primary,
        [type="submit"].primary,
        [type="reset"].primary,
        .button.primary,
        [role="button"].primar {
            --button-back-color: var(--fc-primary);
        }

        html,
        body {
            background-color: slategray;
        }

        body {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        body,
        input {
            cursor: default;
        }

        .fc-form-cards>div {
            height: 20rem;
            padding: 1rem;
        }

        .fc-form-cards>div>.card {
            height: 95%;
        }

        .fc-form-cards>div .dark {
            height: 100%;
        }

        .card,
        input {
            border-radius: 0.5rem !important;
        }

        table thead {
            border-bottom: none;
        }

        thead>tr>th {
            text-align: center;
        }

        tbody>tr>th {
            flex: 0 0 20% !important;
            border-top: .0625rem solid var(--table-border-color);
            border-right: .0625rem solid var(--table-border-color);
        }

        tbody>tr:first-child>th {
            border-top: none;
        }

        #fc-tables table {
            overflow: hidden;
        }

        #fc-tables>.section {
            padding: 1rem;
        }

        #fc-tables table+table {
            margin-top: 1rem;
        }

        #fc-tables mark {
            font-size: 1.1rem;
            width: 18rem;
            display: inline-block;
            line-height: 1.5rem;
            background-color: var(--fc-primary);
        }

        tr.hidden-md td {
            text-align: center;
        }

        tr.hidden-md mark {
            width: auto !important;
        }

        .fc-form {
            padding: 1rem !important;
        }

        button {
            cursor: pointer
        }

        input,
        #uppercaseRadioButtons {
            text-align: center;
        }

        #uppercaseRadioButtons {
            margin: 0.5rem 0;
        }

        .fc-form>input {
            width: 100%;
            margin-right: 0 !important;
            margin-left: 0 !important;

        }

        label {
            cursor: pointer;
        }

        [type="radio"] {
            vertical-align: bottom;
            cursor: pointer;
        }

        .fc-compute-overlay {
            cursor: wait;
            position: absolute !important;
            width: 100% !important;
            height: 100% !important;
        }

        .fc-compute-spinner {
            box-sizing: border-box;
            --size: 10rem;
            border-width: calc(var(--size) / 7.5);
            width: var(--size);
            height: var(--size);
            position: relative;
            border-top-color: var(--button-back-color);
            margin: auto;
        }

        #debug-bar * {
            /* don't apply minicss to debugbar */
            all: revert;
        }
    </style>
    <script>
        function doubleAjaxCompute() {
            const xhr = new XMLHttpRequest();
            if (doubleInput.value === '') {
                doubleInput.focus();
                return;
            }
            if (!doubleInput.checkValidity()) {
                doubleInput.value = '';
                doubleInput.focus();
                return;
            }
            doubleSwitchToWaitResultState();
            xhr.open('GET', document.location.href + '/compute-double/' + doubleInput.value, true);

            // https://codeigniter4.github.io/CodeIgniter4/general/ajax.html
            // To get around this problem, the most efficient solution (so far) is to manually define the request header, forcing the information to be sent to the server, which will then be able to identify that the request is XHR.
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.setRequestHeader('Accept', 'text/plain');

            xhr.onreadystatechange = () => {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    doubleResult.value = xhr.response;
                } else {
                    console.log(xhr.status + ' ' + xhr.readyState);
                }
                doubleSwitchToDoneState();
            }

            xhr.send(null);
        }

        function uppercaseAjaxCompute() {
            const xhr = new XMLHttpRequest();
            if (uppercaseInput.value === '') {
                uppercaseInput.focus();
                return;
            }
            if (!uppercaseInput.checkValidity()) {
                uppercaseInput.value = '';
                uppercaseInput.focus();
                return;
            }
            uppercaseSwitchToWaitResultState();
            let formData = new FormData();
            formData.append('word', uppercaseInput.value);

            let format = document.querySelector('#uppercaseRadioButtons [name="content-type"]:checked').value;

            xhr.open('POST', document.location.href + '/compute-uppercase', true);

            // https://codeigniter4.github.io/CodeIgniter4/general/ajax.html
            // To get around this problem, the most efficient solution (so far) is to manually define the request header, forcing the information to be sent to the server, which will then be able to identify that the request is XHR.
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Accept', 'application/' + format);

            xhr.responseType = format; // => xml or json xhr.response Objectdirect

            xhr.onreadystatechange = () => {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    switch (format) {
                        case 'json':
                            result = xhr.response.result;
                            break;
                        case 'xml':
                            // https://developer.mozilla.org/en-US/docs/Web/API/XMLDocument
                            result = xhr.responseXML.getElementsByTagName('result')[0].textContent;
                            break;
                    }
                    uppercaseResult.value = result;
                } else {
                    console.log(xhr.status + ' ' + xhr.readyState);
                }
                uppercaseSwitchToDoneState();
            }

            xhr.send(formData);
        }


        function computeSwitchToWaitInput(card) {
            document.getElementById(card + 'Result').value = '';
            document.getElementById(card + 'Result').disabled = true;
        }

        function doubleSwitchToWaitInput() {
            computeSwitchToWaitInput('double');
        }

        function uppercaseSwitchToWaitInput() {
            computeSwitchToWaitInput('uppercase');
        }

        function computeSwitchToWaitResultState(card) {
            document.getElementById(card + 'Compute').disabled = true;
            document.getElementById(card + 'Input').readOnly = true;
            document.getElementById(card + 'ComputeModalCheckbox').checked = true;
        }

        function doubleSwitchToWaitResultState() {
            computeSwitchToWaitResultState('double');
        }

        function uppercaseSwitchToWaitResultState() {
            computeSwitchToWaitResultState('uppercase');
        }

        function computeSwitchToDoneState(card) {
            document.getElementById(card + 'Compute').disabled = false;
            document.getElementById(card + 'Input').readOnly = false;
            document.getElementById(card + 'Result').disabled = false;
            document.getElementById(card + 'ComputeModalCheckbox').checked = false;
            document.getElementById(card + 'Input').focus();

        }

        function doubleSwitchToDoneState() {
            computeSwitchToDoneState('double');
        }

        function uppercaseSwitchToDoneState() {
            computeSwitchToDoneState('uppercase');
        }
    </script>
</head>

<body class="row">
    <main class="container col-sm-12 col-md-10 col-lg-6">
        <div class="row">
            <div class="col-sm-12">
                <div class="card fluid shadowed">
                    <div class="section dark">
                        <h1 id="pageTitle"></h1>
                    </div>
                    <div class="section">
                        <h3>The Project is on GitHub <a href="TODO"><span class="icon-link"></span></a></h3>

                    </div>
                </div>
            </div>
        </div>
        <div class="row cols-sm-12 cols-md-6 fc-form-cards">
            <div>
                <div class="card fluid shadowed">
                    <div class="section">
                        <h3>Compute Double</h3>
                    </div>
                    <div class="section dark fc-form">
                        <input id="doubleInput" pattern="^-?[0-9]+$" oninput="doubleSwitchToWaitInput()" placeholder="integer">
                        <input id="doubleCompute" type="button" onclick="doubleAjaxCompute()" class="primary" value="Compute">
                        <input id="doubleResult" type="text" readonly placeholder="double">
                    </div>
                    <input type="checkbox" id="doubleComputeModalCheckbox" class="modal">
                    <div id="doubleComputeModalOverlay" class="fc-compute-overlay">
                        <!--<span id="computeToast" class="toast">We must waiting the end of the server calculation</span>-->
                        <div id="doubleComputeSpinner" class="spinner primary fc-compute-spinner"></div>
                    </div>
                </div>
            </div>
            <div>
                <div class="card fluid shadowed">
                    <div class="section">
                        <h3>Compute Uppercase</h3>
                    </div>
                    <div class="section dark fc-form">
                        <input id="uppercaseInput" pattern="^[a-zA-Z]+$" oninput="uppercaseSwitchToWaitInput()" placeholder="word">
                        <input id="uppercaseCompute" type="button" onclick="uppercaseAjaxCompute()" class="primary" value="Compute">
                        <div id="uppercaseRadioButtons">Type:&nbsp;&nbsp;
                            <label for="uppercaseRadioXML">&nbsp;XML</label><input id="uppercaseRadioXML" type="radio" name="content-type" value="xml">
                            <label for="uppercaseRadioJSON">&nbsp;JSON</label><input id="uppercaseRadioJSON" type="radio" name="content-type" value="json" checked>
                        </div>
                        <input id="uppercaseResult" type="text" readonly placeholder="uppercase">
                    </div>
                    <input type="checkbox" id="uppercaseComputeModalCheckbox" class="modal">
                    <div id="uppercaseComputeModalOverlay" class="fc-compute-overlay">
                        <!--<span id="computeToast" class="toast">We must waiting the end of the server calculation</span>-->
                        <div id="uppercaseComputeSpinner" class="spinner primary fc-compute-spinner"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card fluid shadowed" id="fc-tables">
                    <div class="section dark">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2"><mark class="tag">DOUBLE of the integer <span class="icon-settings inverse"></span></mark></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hidden-md hidden-lg">
                                    <td data-label=""><mark class="tag">DOUBLE of the integer <span class="icon-settings inverse"></span> </mark></td>
                                </tr>
                                <tr>
                                    <th>HTTP Method</th>
                                    <td data-label="HTTP Method">GET /ajax-examples/compute-double/integer</td>
                                </tr>
                                <tr>
                                    <th>Content-Type</th>
                                    <td data-label="Content-Type">text/plain</td>
                                </tr>
                                <tr>
                                    <th>Response</th>
                                    <td data-label="Response">"Handmade"
                                        <a href="https://codeigniter.com/user_guide/outgoing/response.html" target="_blank"><span class="icon-link"></span></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2"><mark class="tag">UPPERCASE ot the word <span class="icon-settings inverse"></span></mark></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hidden-md hidden-lg">
                                    <td colspan="2" data-label=""><mark class="tag">UPPERCASE ot the word <span class="icon-settings inverse"></span></mark></td>
                                </tr>
                                <tr>
                                    <th>HTTP Method</th>
                                    <td data-label="HTTP Method">POST /ajax-examples/compute-uppercase</td>
                                </tr>
                                <tr>
                                    <th>Content-Type</th>
                                    <td data-label="Content-Type">application/xml or application/json</td>
                                </tr>
                                <tr>
                                    <th>Response</th>
                                    <td data-label="Response">CodeIgniter\API\ResponseTrait and Content Negotiation
                                        <a href="https://codeigniter.com/user_guide/outgoing/api_responses.html" target="_blank"><span class="icon-link"></span></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        pageTitle.textContent = document.title;
        doubleSwitchToWaitInput();
        uppercaseSwitchToWaitInput();
        doubleInput.focus();
    </script>
</body>

</html>