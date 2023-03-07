<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Velog .md Extractor</title>
    <script type="text/javascript" src="../lib/Common.js"></script>
    <style type="text/css">
      #wrapper {
        width: 100%;
        margin: 0px auto;
        padding: 20px;
        border-style: dotted;
        border-radius: 20px;
        border: 1px solid #828282;
      }
      #header {
        margin-bottom: 20px;
        padding: 20px;
        border: 1px solid #828282;
        display: flex;
      }
      .header_left {
        margin-left: 10px;
      }
      #footer {
        clear: both;
        border-style: groove;
        margin: 0px 5px;
        background-color: #fff;
        color: black;
        text-align: center;
        border: 1px solid #828282;
      }
      .content {
        display: flex;
        width: 100%;
        height: 500px;
        clear: both;
        border-style: groove;
        background-color: #fff;
        color: black;
        text-align: center;
        border: 1px solid #828282;
        margin-bottom: 10px;
      }
      .content .left {
        background: cornflowerblue;
        width: 50%;
        height: 100%;
      }
      .content .right {
        background: lightcoral;
        width: 50%;
        height: 100%;
      }
      .text_area {
        width: 90%;
        height: 90%;
        margin-top: 10px;
      }
      #converter {
        width: 100px;
        margin-bottom: 10px;
      }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="header">
        <div>
            <h2> 사용법 </h2>
            <h5> Velog 사용자명 입력</h5>
            <h5> 왼쪽 파란색 영역에 Velog Cookie jwt 토큰 입력</h5>
            <h5> MD 추출 버튼 입력</h5>
            <h5> /posts에 post파일이 md로 생성됨</h5>
            <h5> /category에 post의 category파일이 md로 생성됨</h5>
        </div>
    </div>
    <span>Velog 사용자명 : </span><input id="user_name" type="text" value="gillog"/>
    <input id="converter" type="button" value="Title 가져오기" onclick="requestVelogPostTitle()"/>
    <input id="converter_file" type="button" value="Post MD 가져오기" onclick="requestVelogPosts()"/>
    <div class="content">
        <div class="left" style="overflow:scroll;">
          <ul id="postTitleArea">

          </ul>
        </div>
        <div class="right">
            <textarea class="text_area" id="result_area" readonly></textarea>
        </div>
    </div>
    <div id="footer">
        <h5> <strong>swgil007@naver.com</strong> | <a href="https://github.com/gil-log/velog_md_extractor">GitHub</a> | <CopyRight>All right is reserved.</CopyRight> </h5>
    </div>
</body>
<script>
  function requestVelogPostTitle() {

    const user_name = document.getElementById("user_name");
    const url = "../api/GetVelogPostTitle.php";
    const method = "POST";
    const requestData = {
      userName : user_name.value
    };
    const appendTitleArea = function (data) {
      var li = document.createElement('li');
      var content = document.createTextNode(data);
      li.appendChild(content);
      var postTitleArea = document.getElementById("postTitleArea");
      postTitleArea.appendChild(li);
    }
    callAjax(url, method, requestData, appendTitleArea);
  }

  function requestVelogPosts() {
    const user_name = document.getElementById("user_name");
    const url = "../api/GetVelogPosts.php";
    const method = "POST";
    const requestData = {
      userName : user_name.value
    };
    const consoleLog = function (data) {
      console.log(data);
    }
    callAjax(url, method, requestData, consoleLog);
  }
</script>
</html>
