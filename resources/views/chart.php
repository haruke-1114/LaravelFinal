<div id='page' class='container, list'>
    <div class='title'>
        <h2>CLHL Chart Analysis</h2>
    </div>

    <div id="main" style="width: 1000px; height:800px;"></div>
</div>
<script>
    var myChart = echarts.init(document.getElementById('main'));
    var places = [],
        nums = [],
        id = [];
    getData();
    /* 此函式將從 database 取得資料 */
    function getData() {
        // console.log("2222");  //測試用
        /* 設定處理 ajax 請求的 php 檔案 */
        var myUrl = "/app/Models/chartDB.php";

        /* 底下是利用發出 jQuery 的 ajax 請求方式去呼叫函式繪製 Google Chart 
         * ajax 的各項屬性意義為.....
         * url: 代表處理 ajax 請求的檔案
         * type: 發出請求的方式。一般設定為 POST 或 GET
         * dataType: 設定從伺服器回傳查詢結果的資料格式
         * data: 要被送至伺服器處理的查詢字串。通常是傳送使用者輸入的查詢條件
         * async: 是否採用非同步(async)的方式處理。預設值是 true
         * success: 請求成功時所要執行的函式
         * error: 請求失敗時所要執行的函式 
         */
        jQuery.ajax({
            url: myUrl,
            type: 'POST',
            async: false,
            data: {},
            dataType: 'json',
            /* 函式中的 backData 參數：伺服器回傳的查詢結果 */
            success: function(backData, jqXHR) {
                if (backData == "null") {
                    document.getElementById('main').innerHTML = "沒有資料!";
                } else {
                    // console.log(backData);
                    /* 將伺服器回傳的查詢結果傳給 drawChart()函式進行 chart 的繪製 */
                    for (var i = 0; i < backData.length; i++) {
                        places.push(backData[i][1]);
                        nums.push(backData[i][0]);
                        id.push(backData[i][2])
                    }
                }
            },
            error: function(textStatus) {
                console.log(" error!");
            }
        })
        return places, nums;
    }

    var option = {
        color: ['#3398DB'],
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: [{
            type: 'category',
            name: '下單時間',
            data: places,
            axisTick: {
                alignWithLabel: true
            }
        }],
        yAxis: {
            type: 'value',
            name: '金額',
            min: 0,
            axisLabel: {
                formatter: '{value}'
            }
        },
        series: [{
            name: '金額',
            type: 'line',
            data: nums,
            lineStyle: {
                width: 8,
            }
        }, ]
    };

    myChart.setOption(option);
</script>