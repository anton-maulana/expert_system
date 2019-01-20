<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<div class="container">
    <form class="form" style="margin-top:100px">
        <div class="form-group">
            <div class="col-sm-5">
                <h4>Multi-select</h4>
                <!-- Using data attributes -->
                <select name="foods" data-selectr-opts='{ "title": "What&#39;s for breakfast? (max 5)", "placeholder": "Search foods", "maxSelection": 5 }'  multiple>
                    <option data-selectr-color="rgb(0, 163, 0)" value="bacon">Bacon (Extra long name foo bar baz quz)</option>
                    <option data-selectr-color="rgb(255, 0, 151)" value="eggs" selected>Eggs</option>
                    <option data-selectr-color="rgb(159, 0, 167)" value="toast">Toast</option>
                    <option data-selectr-color="rgb(185, 29, 71)" value="oatmeal">Oatmeal</option>
                    <option data-selectr-color="rgb(227, 162, 26)" value="steak" selected>Steak</option>
                    <option data-selectr-color="rgb(218, 83, 44)" value="sausage">Sausage</option>
                    <option data-selectr-color="rgb(45, 137, 239)" value="fruit">Fresh Fruit</option>
                </select>
            </div>
        </div>
        <h2>
            Pilih Kendala dibawah ini
        </h2>
        <div class="form-group">
            <label for="diagnosis-name">Nama Diagnosa</label>
            <input type="text" class="form-control" id="diagnosis-name" aria-describedby="emailHelp" placeholder="Syakit Hati">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Kirim</button>
    </form>              
</div>
<script src="../assets/js/selectr.js"></script>
<script src="./scripts/insertDiagnosis.js"></script>