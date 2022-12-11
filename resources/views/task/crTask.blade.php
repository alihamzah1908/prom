<style>
    .form-group{
        width:100%;
    }
    .col-md-5x{
        width:100% !important;
        height:100% !important;
        padding-left: 15px;
        padding-right: 15px;
    }
</style>
<div class="card-body"><br>
<div class="row" hidden>
        <div class="col-md-12">
            <div class="form-group" style="margin-bottom: 0;">
                <label><h6><strong>Choose task time</strong></h6></label>
            </div>
            Send task with Schedule <input type="radio" name="pilih_waktu" value="dengan_jadwal" />&nbsp;&nbsp;&nbsp;&nbsp;
            Send task immediately(now) <input type="radio" name="pilih_waktu" value="sekarang" checked/><br><br>
            <span class="pilihan_jadwal">Daily <input type="radio" name="selectFrequency" value="dailyAt"/></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="pilihan_jadwal">Weekly <input type="radio" name="selectFrequency" value="weeklyOn"/></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="pilihan_jadwal">Monthly<input type="radio" name="selectFrequency" value="monthlyOn"/> </span><br>
            <div class="row">
                <select class="form-control otherAnswerDaily" style="width: 30%;" name="jam">
                    <option value="" selected disabled>-- Select Hours --</option>
                    <option value="1" {{  ($task->jam == "1" ? ' selected' : '') }}>01</option>
                    <option value="2" {{  ($task->jam == "2" ? ' selected' : '') }}>02</option>
                    <option value="3" {{  ($task->jam == "3" ? ' selected' : '') }}>03</option>
                    <option value="4" {{  ($task->jam == "4" ? ' selected' : '') }}>04</option>
                    <option value="5" {{  ($task->jam == "5" ? ' selected' : '') }}>05</option>
                    <option value="6" {{  ($task->jam == "6" ? ' selected' : '') }}>06</option>
                    <option value="7" {{  ($task->jam == "7" ? ' selected' : '') }}>07</option>
                    <option value="8" {{  ($task->jam == "8" ? ' selected' : '') }}>08</option>
                    <option value="9" {{  ($task->jam == "9" ? ' selected' : '') }}>09</option>
                    <option value="10" {{  ($task->jam == "10" ? ' selected' : '') }}>10</option>
                    <option value="11" {{  ($task->jam == "11" ? ' selected' : '') }}>11</option>
                    <option value="12" {{  ($task->jam == "12" ? ' selected' : '') }}>12</option>
                    <option value="13" {{  ($task->jam == "13" ? ' selected' : '') }}>13</option>
                    <option value="14" {{  ($task->jam == "14" ? ' selected' : '') }}>14</option>
                    <option value="15" {{  ($task->jam == "15" ? ' selected' : '') }}>15</option>
                    <option value="16" {{  ($task->jam == "16" ? ' selected' : '') }}>16</option>
                    <option value="17" {{  ($task->jam == "17" ? ' selected' : '') }}>17</option>
                    <option value="18" {{  ($task->jam == "18" ? ' selected' : '') }}>18</option>
                    <option value="19" {{  ($task->jam == "19" ? ' selected' : '') }}>19</option>
                    <option value="20" {{  ($task->jam == "20" ? ' selected' : '') }}>20</option>
                    <option value="21" {{  ($task->jam == "21" ? ' selected' : '') }}>21</option>
                    <option value="22" {{  ($task->jam == "22" ? ' selected' : '') }}>22</option>
                    <option value="23" {{  ($task->jam == "23" ? ' selected' : '') }}>23</option>
                    <option value="0" {{  ($task->jam == "0" ? ' selected' : '') }}>00</option>
                </select>&nbsp;&nbsp;
                <select class="form-control otherAnswerDaily" style="width: 30%;" name="menit">
                    <option value="" selected disabled>-- Select Minute --</option>
                    <option value="1" {{  ($task->menit == "1" ? ' selected' : '') }}>01</option>
                    <option value="2" {{  ($task->menit == "2" ? ' selected' : '') }}>02</option>
                    <option value="3" {{  ($task->menit == "3" ? ' selected' : '') }}>03</option>
                    <option value="4" {{  ($task->menit == "4" ? ' selected' : '') }}>04</option>
                    <option value="5" {{  ($task->menit == "5" ? ' selected' : '') }}>05</option>
                    <option value="6" {{  ($task->menit == "6" ? ' selected' : '') }}>06</option>
                    <option value="7" {{  ($task->menit == "7" ? ' selected' : '') }}>07</option>
                    <option value="8" {{  ($task->menit == "8" ? ' selected' : '') }}>08</option>
                    <option value="9" {{  ($task->menit == "9" ? ' selected' : '') }}>09</option>
                    <option value="10" {{  ($task->menit == "10" ? ' selected' : '') }}>10</option>
                    <option value="11" {{  ($task->menit == "11" ? ' selected' : '') }}>11</option>
                    <option value="12" {{  ($task->menit == "12" ? ' selected' : '') }}>12</option>
                    <option value="13" {{  ($task->menit == "13" ? ' selected' : '') }}>13</option>
                    <option value="14" {{  ($task->menit == "14" ? ' selected' : '') }}>14</option>
                    <option value="15" {{  ($task->menit == "15" ? ' selected' : '') }}>15</option>
                    <option value="16" {{  ($task->menit == "16" ? ' selected' : '') }}>16</option>
                    <option value="17" {{  ($task->menit == "17" ? ' selected' : '') }}>17</option>
                    <option value="18" {{  ($task->menit == "18" ? ' selected' : '') }}>18</option>
                    <option value="19" {{  ($task->menit == "19" ? ' selected' : '') }}>19</option>
                    <option value="20" {{  ($task->menit == "20" ? ' selected' : '') }}>20</option>
                    <option value="21" {{  ($task->menit == "21" ? ' selected' : '') }}>21</option>
                    <option value="22" {{  ($task->menit == "22" ? ' selected' : '') }}>22</option>
                    <option value="23" {{  ($task->menit == "23" ? ' selected' : '') }}>23</option>
                    <option value="24" {{  ($task->menit == "24" ? ' selected' : '') }}>24</option>
                    <option value="25" {{  ($task->menit == "25" ? ' selected' : '') }}>25</option>
                    <option value="26" {{  ($task->menit == "26" ? ' selected' : '') }}>26</option>
                    <option value="27" {{  ($task->menit == "27" ? ' selected' : '') }}>27</option>
                    <option value="28" {{  ($task->menit == "28" ? ' selected' : '') }}>28</option>
                    <option value="29" {{  ($task->menit == "29" ? ' selected' : '') }}>29</option>
                    <option value="30" {{  ($task->menit == "30" ? ' selected' : '') }}>30</option>
                    <option value="31" {{  ($task->menit == "31" ? ' selected' : '') }}>31</option>
                    <option value="32" {{  ($task->menit == "32" ? ' selected' : '') }}>32</option>
                    <option value="33" {{  ($task->menit == "33" ? ' selected' : '') }}>33</option>
                    <option value="34" {{  ($task->menit == "34" ? ' selected' : '') }}>34</option>
                    <option value="35" {{  ($task->menit == "35" ? ' selected' : '') }}>35</option>
                    <option value="36" {{  ($task->menit == "36" ? ' selected' : '') }}>36</option>
                    <option value="37" {{  ($task->menit == "37" ? ' selected' : '') }}>37</option>
                    <option value="38" {{  ($task->menit == "38" ? ' selected' : '') }}>38</option>
                    <option value="39" {{  ($task->menit == "39" ? ' selected' : '') }}>39</option>
                    <option value="40" {{  ($task->menit == "40" ? ' selected' : '') }}>40</option>
                    <option value="41" {{  ($task->menit == "41" ? ' selected' : '') }}>41</option>
                    <option value="42" {{  ($task->menit == "42" ? ' selected' : '') }}>42</option>
                    <option value="43" {{  ($task->menit == "43" ? ' selected' : '') }}>43</option>
                    <option value="44" {{  ($task->menit == "44" ? ' selected' : '') }}>44</option>
                    <option value="45" {{  ($task->menit == "45" ? ' selected' : '') }}>45</option>
                    <option value="46" {{  ($task->menit == "46" ? ' selected' : '') }}>46</option>
                    <option value="47" {{  ($task->menit == "47" ? ' selected' : '') }}>47</option>
                    <option value="48" {{  ($task->menit == "48" ? ' selected' : '') }}>48</option>
                    <option value="49" {{  ($task->menit == "49" ? ' selected' : '') }}>49</option>
                    <option value="50" {{  ($task->menit == "50" ? ' selected' : '') }}>50</option>
                    <option value="51" {{  ($task->menit == "51" ? ' selected' : '') }}>51</option>
                    <option value="52" {{  ($task->menit == "52" ? ' selected' : '') }}>52</option>
                    <option value="53" {{  ($task->menit == "53" ? ' selected' : '') }}>53</option>
                    <option value="54" {{  ($task->menit == "54" ? ' selected' : '') }}>54</option>
                    <option value="55" {{  ($task->menit == "55" ? ' selected' : '') }}>55</option>
                    <option value="56" {{  ($task->menit == "56" ? ' selected' : '') }}>56</option>
                    <option value="57" {{  ($task->menit == "57" ? ' selected' : '') }}>57</option>
                    <option value="58" {{  ($task->menit == "58" ? ' selected' : '') }}>58</option>
                    <option value="59" {{  ($task->menit == "59" ? ' selected' : '') }}>59</option>
                    <option value="0" {{  ($task->menit == "0" ? ' selected' : '') }}>00</option>
                </select><br>
                <select class="form-control otherAnswerWeekly" style="width: 30%; display:none;" name="hari">
                    <option value="" selected disabled>-- Select Day --</option>
                    <option value="1" {{  ($task->hari == "1" ? ' selected' : '') }}>Senin</option>
                    <option value="2" {{  ($task->hari == "2" ? ' selected' : '') }}>Selasa</option>
                    <option value="3" {{  ($task->hari == "3" ? ' selected' : '') }}>Rabu</option>
                    <option value="4" {{  ($task->hari == "4" ? ' selected' : '') }}>Kamis</option>
                    <option value="5" {{  ($task->hari == "5" ? ' selected' : '') }}>Jum'at</option>
                    <option value="6" {{  ($task->hari == "6" ? ' selected' : '') }}>Sabtu</option>
                    <option value="7" {{  ($task->hari == "7" ? ' selected' : '') }}>Ahad</option>
                </select>&nbsp;&nbsp;
                <select class="form-control otherAnswerWeekly" style="width: 30%; display:none;" name="jam">
                    <option value="" selected disabled>-- Select Hours --</option>
                    <option value="1" {{  ($task->jam == "1" ? ' selected' : '') }}>01</option>
                    <option value="2" {{  ($task->jam == "2" ? ' selected' : '') }}>02</option>
                    <option value="3" {{  ($task->jam == "3" ? ' selected' : '') }}>03</option>
                    <option value="4" {{  ($task->jam == "4" ? ' selected' : '') }}>04</option>
                    <option value="5" {{  ($task->jam == "5" ? ' selected' : '') }}>05</option>
                    <option value="6" {{  ($task->jam == "6" ? ' selected' : '') }}>06</option>
                    <option value="7" {{  ($task->jam == "7" ? ' selected' : '') }}>07</option>
                    <option value="8" {{  ($task->jam == "8" ? ' selected' : '') }}>08</option>
                    <option value="9" {{  ($task->jam == "9" ? ' selected' : '') }}>09</option>
                    <option value="10" {{  ($task->jam == "10" ? ' selected' : '') }}>10</option>
                    <option value="11" {{  ($task->jam == "11" ? ' selected' : '') }}>11</option>
                    <option value="12" {{  ($task->jam == "12" ? ' selected' : '') }}>12</option>
                    <option value="13" {{  ($task->jam == "13" ? ' selected' : '') }}>13</option>
                    <option value="14" {{  ($task->jam == "14" ? ' selected' : '') }}>14</option>
                    <option value="15" {{  ($task->jam == "15" ? ' selected' : '') }}>15</option>
                    <option value="16" {{  ($task->jam == "16" ? ' selected' : '') }}>16</option>
                    <option value="17" {{  ($task->jam == "17" ? ' selected' : '') }}>17</option>
                    <option value="18" {{  ($task->jam == "18" ? ' selected' : '') }}>18</option>
                    <option value="19" {{  ($task->jam == "19" ? ' selected' : '') }}>19</option>
                    <option value="20" {{  ($task->jam == "20" ? ' selected' : '') }}>20</option>
                    <option value="21" {{  ($task->jam == "21" ? ' selected' : '') }}>21</option>
                    <option value="22" {{  ($task->jam == "22" ? ' selected' : '') }}>22</option>
                    <option value="23" {{  ($task->jam == "23" ? ' selected' : '') }}>23</option>
                    <option value="0" {{  ($task->jam == "0" ? ' selected' : '') }}>00</option>
                </select>&nbsp;&nbsp;
                <select class="form-control otherAnswerWeekly" style="width: 30%; display:none;" name="menit">
                    <option value="" selected disabled>-- Select Minute --</option>
                    <option value="1" {{  ($task->menit == "1" ? ' selected' : '') }}>01</option>
                    <option value="2" {{  ($task->menit == "2" ? ' selected' : '') }}>02</option>
                    <option value="3" {{  ($task->menit == "3" ? ' selected' : '') }}>03</option>
                    <option value="4" {{  ($task->menit == "4" ? ' selected' : '') }}>04</option>
                    <option value="5" {{  ($task->menit == "5" ? ' selected' : '') }}>05</option>
                    <option value="6" {{  ($task->menit == "6" ? ' selected' : '') }}>06</option>
                    <option value="7" {{  ($task->menit == "7" ? ' selected' : '') }}>07</option>
                    <option value="8" {{  ($task->menit == "8" ? ' selected' : '') }}>08</option>
                    <option value="9" {{  ($task->menit == "9" ? ' selected' : '') }}>09</option>
                    <option value="10" {{  ($task->menit == "10" ? ' selected' : '') }}>10</option>
                    <option value="11" {{  ($task->menit == "11" ? ' selected' : '') }}>11</option>
                    <option value="12" {{  ($task->menit == "12" ? ' selected' : '') }}>12</option>
                    <option value="13" {{  ($task->menit == "13" ? ' selected' : '') }}>13</option>
                    <option value="14" {{  ($task->menit == "14" ? ' selected' : '') }}>14</option>
                    <option value="15" {{  ($task->menit == "15" ? ' selected' : '') }}>15</option>
                    <option value="16" {{  ($task->menit == "16" ? ' selected' : '') }}>16</option>
                    <option value="17" {{  ($task->menit == "17" ? ' selected' : '') }}>17</option>
                    <option value="18" {{  ($task->menit == "18" ? ' selected' : '') }}>18</option>
                    <option value="19" {{  ($task->menit == "19" ? ' selected' : '') }}>19</option>
                    <option value="20" {{  ($task->menit == "20" ? ' selected' : '') }}>20</option>
                    <option value="21" {{  ($task->menit == "21" ? ' selected' : '') }}>21</option>
                    <option value="22" {{  ($task->menit == "22" ? ' selected' : '') }}>22</option>
                    <option value="23" {{  ($task->menit == "23" ? ' selected' : '') }}>23</option>
                    <option value="24" {{  ($task->menit == "24" ? ' selected' : '') }}>24</option>
                    <option value="25" {{  ($task->menit == "25" ? ' selected' : '') }}>25</option>
                    <option value="26" {{  ($task->menit == "26" ? ' selected' : '') }}>26</option>
                    <option value="27" {{  ($task->menit == "27" ? ' selected' : '') }}>27</option>
                    <option value="28" {{  ($task->menit == "28" ? ' selected' : '') }}>28</option>
                    <option value="29" {{  ($task->menit == "29" ? ' selected' : '') }}>29</option>
                    <option value="30" {{  ($task->menit == "30" ? ' selected' : '') }}>30</option>
                    <option value="31" {{  ($task->menit == "31" ? ' selected' : '') }}>31</option>
                    <option value="32" {{  ($task->menit == "32" ? ' selected' : '') }}>32</option>
                    <option value="33" {{  ($task->menit == "33" ? ' selected' : '') }}>33</option>
                    <option value="34" {{  ($task->menit == "34" ? ' selected' : '') }}>34</option>
                    <option value="35" {{  ($task->menit == "35" ? ' selected' : '') }}>35</option>
                    <option value="36" {{  ($task->menit == "36" ? ' selected' : '') }}>36</option>
                    <option value="37" {{  ($task->menit == "37" ? ' selected' : '') }}>37</option>
                    <option value="38" {{  ($task->menit == "38" ? ' selected' : '') }}>38</option>
                    <option value="39" {{  ($task->menit == "39" ? ' selected' : '') }}>39</option>
                    <option value="40" {{  ($task->menit == "40" ? ' selected' : '') }}>40</option>
                    <option value="41" {{  ($task->menit == "41" ? ' selected' : '') }}>41</option>
                    <option value="42" {{  ($task->menit == "42" ? ' selected' : '') }}>42</option>
                    <option value="43" {{  ($task->menit == "43" ? ' selected' : '') }}>43</option>
                    <option value="44" {{  ($task->menit == "44" ? ' selected' : '') }}>44</option>
                    <option value="45" {{  ($task->menit == "45" ? ' selected' : '') }}>45</option>
                    <option value="46" {{  ($task->menit == "46" ? ' selected' : '') }}>46</option>
                    <option value="47" {{  ($task->menit == "47" ? ' selected' : '') }}>47</option>
                    <option value="48" {{  ($task->menit == "48" ? ' selected' : '') }}>48</option>
                    <option value="49" {{  ($task->menit == "49" ? ' selected' : '') }}>49</option>
                    <option value="50" {{  ($task->menit == "50" ? ' selected' : '') }}>50</option>
                    <option value="51" {{  ($task->menit == "51" ? ' selected' : '') }}>51</option>
                    <option value="52" {{  ($task->menit == "52" ? ' selected' : '') }}>52</option>
                    <option value="53" {{  ($task->menit == "53" ? ' selected' : '') }}>53</option>
                    <option value="54" {{  ($task->menit == "54" ? ' selected' : '') }}>54</option>
                    <option value="55" {{  ($task->menit == "55" ? ' selected' : '') }}>55</option>
                    <option value="56" {{  ($task->menit == "56" ? ' selected' : '') }}>56</option>
                    <option value="57" {{  ($task->menit == "57" ? ' selected' : '') }}>57</option>
                    <option value="58" {{  ($task->menit == "58" ? ' selected' : '') }}>58</option>
                    <option value="59" {{  ($task->menit == "59" ? ' selected' : '') }}>59</option>
                    <option value="0" {{  ($task->menit == "0" ? ' selected' : '') }}>00</option>
                </select><br>
                <select class="form-control otherAnswerMonthly" style="width: 30%; display:none;" name="tanggal">
                    <option value="" selected disabled>-- Select Date --</option>
                    <option value="1" {{  ($task->tanggal == "1" ? ' selected' : '') }}>01</option>
                    <option value="2" {{  ($task->tanggal == "2" ? ' selected' : '') }}>02</option>
                    <option value="3" {{  ($task->tanggal == "3" ? ' selected' : '') }}>03</option>
                    <option value="4" {{  ($task->tanggal == "4" ? ' selected' : '') }}>04</option>
                    <option value="5" {{  ($task->tanggal == "5" ? ' selected' : '') }}>05</option>
                    <option value="6" {{  ($task->tanggal == "6" ? ' selected' : '') }}>06</option>
                    <option value="7" {{  ($task->tanggal == "7" ? ' selected' : '') }}>07</option>
                    <option value="8" {{  ($task->tanggal == "8" ? ' selected' : '') }}>08</option>
                    <option value="9" {{  ($task->tanggal == "9" ? ' selected' : '') }}>09</option>
                    <option value="10" {{  ($task->tanggal == "10" ? ' selected' : '') }}>10</option>
                    <option value="11" {{  ($task->tanggal == "11" ? ' selected' : '') }}>11</option>
                    <option value="12" {{  ($task->tanggal == "12" ? ' selected' : '') }}>12</option>
                    <option value="13" {{  ($task->tanggal == "13" ? ' selected' : '') }}>13</option>
                    <option value="14" {{  ($task->tanggal == "14" ? ' selected' : '') }}>14</option>
                    <option value="15" {{  ($task->tanggal == "15" ? ' selected' : '') }}>15</option>
                    <option value="16" {{  ($task->tanggal == "16" ? ' selected' : '') }}>16</option>
                    <option value="17" {{  ($task->tanggal == "17" ? ' selected' : '') }}>17</option>
                    <option value="18" {{  ($task->tanggal == "18" ? ' selected' : '') }}>18</option>
                    <option value="19" {{  ($task->tanggal == "19" ? ' selected' : '') }}>19</option>
                    <option value="20" {{  ($task->tanggal == "20" ? ' selected' : '') }}>20</option>
                    <option value="21" {{  ($task->tanggal == "21" ? ' selected' : '') }}>21</option>
                    <option value="22" {{  ($task->tanggal == "22" ? ' selected' : '') }}>22</option>
                    <option value="23" {{  ($task->tanggal == "23" ? ' selected' : '') }}>23</option>
                    <option value="24" {{  ($task->tanggal == "24" ? ' selected' : '') }}>24</option>
                    <option value="25" {{  ($task->tanggal == "25" ? ' selected' : '') }}>25</option>
                    <option value="26" {{  ($task->tanggal == "26" ? ' selected' : '') }}>26</option>
                    <option value="27" {{  ($task->tanggal == "27" ? ' selected' : '') }}>27</option>
                    <option value="28" {{  ($task->tanggal == "28" ? ' selected' : '') }}>28</option>
                </select>&nbsp;&nbsp;
                <select class="form-control otherAnswerMonthly" style="width: 30%; display:none;" name="jam">
                <option value="" selected disabled>-- Select Hours --</option>
                    <option value="1" {{  ($task->jam == "1" ? ' selected' : '') }}>01</option>
                    <option value="2" {{  ($task->jam == "2" ? ' selected' : '') }}>02</option>
                    <option value="3" {{  ($task->jam == "3" ? ' selected' : '') }}>03</option>
                    <option value="4" {{  ($task->jam == "4" ? ' selected' : '') }}>04</option>
                    <option value="5" {{  ($task->jam == "5" ? ' selected' : '') }}>05</option>
                    <option value="6" {{  ($task->jam == "6" ? ' selected' : '') }}>06</option>
                    <option value="7" {{  ($task->jam == "7" ? ' selected' : '') }}>07</option>
                    <option value="8" {{  ($task->jam == "8" ? ' selected' : '') }}>08</option>
                    <option value="9" {{  ($task->jam == "9" ? ' selected' : '') }}>09</option>
                    <option value="10" {{  ($task->jam == "10" ? ' selected' : '') }}>10</option>
                    <option value="11" {{  ($task->jam == "11" ? ' selected' : '') }}>11</option>
                    <option value="12" {{  ($task->jam == "12" ? ' selected' : '') }}>12</option>
                    <option value="13" {{  ($task->jam == "13" ? ' selected' : '') }}>13</option>
                    <option value="14" {{  ($task->jam == "14" ? ' selected' : '') }}>14</option>
                    <option value="15" {{  ($task->jam == "15" ? ' selected' : '') }}>15</option>
                    <option value="16" {{  ($task->jam == "16" ? ' selected' : '') }}>16</option>
                    <option value="17" {{  ($task->jam == "17" ? ' selected' : '') }}>17</option>
                    <option value="18" {{  ($task->jam == "18" ? ' selected' : '') }}>18</option>
                    <option value="19" {{  ($task->jam == "19" ? ' selected' : '') }}>19</option>
                    <option value="20" {{  ($task->jam == "20" ? ' selected' : '') }}>20</option>
                    <option value="21" {{  ($task->jam == "21" ? ' selected' : '') }}>21</option>
                    <option value="22" {{  ($task->jam == "22" ? ' selected' : '') }}>22</option>
                    <option value="23" {{  ($task->jam == "23" ? ' selected' : '') }}>23</option>
                    <option value="0" {{  ($task->jam == "0" ? ' selected' : '') }}>00</option>
                </select>&nbsp;&nbsp;
                <select class="form-control otherAnswerMonthly" style="width: 30%; display:none;" name="menit">
                <option value="" selected disabled>-- Select Minute --</option>
                    <option value="1" {{  ($task->menit == "1" ? ' selected' : '') }}>01</option>
                    <option value="2" {{  ($task->menit == "2" ? ' selected' : '') }}>02</option>
                    <option value="3" {{  ($task->menit == "3" ? ' selected' : '') }}>03</option>
                    <option value="4" {{  ($task->menit == "4" ? ' selected' : '') }}>04</option>
                    <option value="5" {{  ($task->menit == "5" ? ' selected' : '') }}>05</option>
                    <option value="6" {{  ($task->menit == "6" ? ' selected' : '') }}>06</option>
                    <option value="7" {{  ($task->menit == "7" ? ' selected' : '') }}>07</option>
                    <option value="8" {{  ($task->menit == "8" ? ' selected' : '') }}>08</option>
                    <option value="9" {{  ($task->menit == "9" ? ' selected' : '') }}>09</option>
                    <option value="10" {{  ($task->menit == "10" ? ' selected' : '') }}>10</option>
                    <option value="11" {{  ($task->menit == "11" ? ' selected' : '') }}>11</option>
                    <option value="12" {{  ($task->menit == "12" ? ' selected' : '') }}>12</option>
                    <option value="13" {{  ($task->menit == "13" ? ' selected' : '') }}>13</option>
                    <option value="14" {{  ($task->menit == "14" ? ' selected' : '') }}>14</option>
                    <option value="15" {{  ($task->menit == "15" ? ' selected' : '') }}>15</option>
                    <option value="16" {{  ($task->menit == "16" ? ' selected' : '') }}>16</option>
                    <option value="17" {{  ($task->menit == "17" ? ' selected' : '') }}>17</option>
                    <option value="18" {{  ($task->menit == "18" ? ' selected' : '') }}>18</option>
                    <option value="19" {{  ($task->menit == "19" ? ' selected' : '') }}>19</option>
                    <option value="20" {{  ($task->menit == "20" ? ' selected' : '') }}>20</option>
                    <option value="21" {{  ($task->menit == "21" ? ' selected' : '') }}>21</option>
                    <option value="22" {{  ($task->menit == "22" ? ' selected' : '') }}>22</option>
                    <option value="23" {{  ($task->menit == "23" ? ' selected' : '') }}>23</option>
                    <option value="24" {{  ($task->menit == "24" ? ' selected' : '') }}>24</option>
                    <option value="25" {{  ($task->menit == "25" ? ' selected' : '') }}>25</option>
                    <option value="26" {{  ($task->menit == "26" ? ' selected' : '') }}>26</option>
                    <option value="27" {{  ($task->menit == "27" ? ' selected' : '') }}>27</option>
                    <option value="28" {{  ($task->menit == "28" ? ' selected' : '') }}>28</option>
                    <option value="29" {{  ($task->menit == "29" ? ' selected' : '') }}>29</option>
                    <option value="30" {{  ($task->menit == "30" ? ' selected' : '') }}>30</option>
                    <option value="31" {{  ($task->menit == "31" ? ' selected' : '') }}>31</option>
                    <option value="32" {{  ($task->menit == "32" ? ' selected' : '') }}>32</option>
                    <option value="33" {{  ($task->menit == "33" ? ' selected' : '') }}>33</option>
                    <option value="34" {{  ($task->menit == "34" ? ' selected' : '') }}>34</option>
                    <option value="35" {{  ($task->menit == "35" ? ' selected' : '') }}>35</option>
                    <option value="36" {{  ($task->menit == "36" ? ' selected' : '') }}>36</option>
                    <option value="37" {{  ($task->menit == "37" ? ' selected' : '') }}>37</option>
                    <option value="38" {{  ($task->menit == "38" ? ' selected' : '') }}>38</option>
                    <option value="39" {{  ($task->menit == "39" ? ' selected' : '') }}>39</option>
                    <option value="40" {{  ($task->menit == "40" ? ' selected' : '') }}>40</option>
                    <option value="41" {{  ($task->menit == "41" ? ' selected' : '') }}>41</option>
                    <option value="42" {{  ($task->menit == "42" ? ' selected' : '') }}>42</option>
                    <option value="43" {{  ($task->menit == "43" ? ' selected' : '') }}>43</option>
                    <option value="44" {{  ($task->menit == "44" ? ' selected' : '') }}>44</option>
                    <option value="45" {{  ($task->menit == "45" ? ' selected' : '') }}>45</option>
                    <option value="46" {{  ($task->menit == "46" ? ' selected' : '') }}>46</option>
                    <option value="47" {{  ($task->menit == "47" ? ' selected' : '') }}>47</option>
                    <option value="48" {{  ($task->menit == "48" ? ' selected' : '') }}>48</option>
                    <option value="49" {{  ($task->menit == "49" ? ' selected' : '') }}>49</option>
                    <option value="50" {{  ($task->menit == "50" ? ' selected' : '') }}>50</option>
                    <option value="51" {{  ($task->menit == "51" ? ' selected' : '') }}>51</option>
                    <option value="52" {{  ($task->menit == "52" ? ' selected' : '') }}>52</option>
                    <option value="53" {{  ($task->menit == "53" ? ' selected' : '') }}>53</option>
                    <option value="54" {{  ($task->menit == "54" ? ' selected' : '') }}>54</option>
                    <option value="55" {{  ($task->menit == "55" ? ' selected' : '') }}>55</option>
                    <option value="56" {{  ($task->menit == "56" ? ' selected' : '') }}>56</option>
                    <option value="57" {{  ($task->menit == "57" ? ' selected' : '') }}>57</option>
                    <option value="58" {{  ($task->menit == "58" ? ' selected' : '') }}>58</option>
                    <option value="59" {{  ($task->menit == "59" ? ' selected' : '') }}>59</option>
                    <option value="0" {{  ($task->menit == "0" ? ' selected' : '') }}>00</option>
                </select><br>
            </div>

            <script>
                $("input[name='pilih_waktu']").change(function(){

                    if($(this).val()=="dengan_jadwal"){
                        $(".pilihan_jadwal").show();
                    }else{
                            $(".pilihan_jadwal").hide(); 
                    }
                    
                });  
                $("input[type='radio']").change(function(){

                    if($(this).val()=="dailyAt")
                    {
                        $(".otherAnswerDaily").show();
                    }
                    else
                    {
                            $(".otherAnswerDaily").hide(); 
                    }
                    if($(this).val()=="weeklyOn")
                    {
                        $(".otherAnswerWeekly").show();
                    }
                    else
                    {
                            $(".otherAnswerWeekly").hide(); 
                    }
                    if($(this).val()=="monthlyOn")
                    {
                        $(".otherAnswerMonthly").show();
                    }
                    else
                    {
                            $(".otherAnswerMonthly").hide(); 
                    }

                }); 
            </script>
        </div>
    </div><br>
    <div class="row">
        <table style="width:100%;">
            <tr>
                <td style="width:50%;">
                    <div class="col-md-5x">
                        <div class="form-group">
                        @if($task->id_category != '')
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>Category</label><br>
                            </div>
                            <div class="col-sm-10">
                                <select class="form-control select2 select_category" id="target" style="width: 100%;" required autofocus name="id_category">
                    
                                <option selected="selected" disabled value="">-- Select Category --</option>
                            @foreach(\App\Model\Category::get() as $cat)
                                <option value="{{$cat->id_category}}">{{$cat->category_name}}</option>
                            @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        </div>
                        <div class="form-group">
                        @if($task->id_region != '')
                        
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label>Region</label><br>
                                </div>
                                
                                <div class="col-sm-10">
                                    <select class="form-control select2" style="width: 100%;" required autofocus name="id_region">
                                    <option selected="selected" disabled value="">-- Select Region --</option>
                                @foreach(\App\Model\Region::get() as $region)
                                    <option value="{{$region->region_id}}" @if(old('id_region') == $region->region_id || $task->id_region == $region->region_id) selected @endif>{{$region->region_name}}</option>
                                @endforeach
                                    </select>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        @if($task->id_location_a != '')
                        
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label>Location A</label><br>
                                </div>
                                
                                <div class="col-sm-10">
                                    <select class="form-control select2" style="width: 100%;" required autofocus name="id_location_a">
                                    <option selected="selected" disabled value="">-- Select Location --</option>
                                @foreach(\App\Model\Segment::get() as $segment)
                                    <option value="{{$segment->id_segment}}" @if(old('id_location_a') == $segment->id_segment || $task->id_location_a == $segment->id_segment) selected @endif>{{$segment->segment_name}}</option>
                                @endforeach
                                    </select>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group"><br>
                        @if($task_detail->id_priority != '')
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="subject">Priority</label>
                                </div>
                                
                                <div class="col-sm-10">
                                    <select class="form-control select2" style="width: 100%;" required autofocus name="id_priority">
                                    <option selected="selected" disabled value="">-- Select Priority --</option>
                                @foreach(\App\Model\Priority::where('id_task_type', $id_template)->get() as $priority)
                                    <option value="{{$priority->id_priority}}" @if(old('id_priority') == $priority->id_priority || $task_detail->id_priority == $priority->id_priority) selected @endif>{{$priority->priority_name}}</option>
                                @endforeach
                                    </select>
                                </div>
                            </div>
                        
                                        
                                    
                        @endif
                        </div>
                        <div class="form-group"><br>
                        @if($task->description != '')
                        
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="description">Description</label>
                                </div>
                                
                                <div class="col-sm-10">
                                    <textarea name="description" class="form-control @error('description') is-invalid invalid @enderror" id="description" rows="4" placeholder="Description" required autofocus>@if(old('description')){{old('description')}}@elseif($task->description){{$task->description}}@endif</textarea>
                                </div>
                            </div>
                        @endif
                        </div>
                        <!--what is attachment-->
                        @if(request()->path() == '/setup/template-form/{id_type}/create')
                        <div class="form-group" >
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label>Attacment</label>
                                </div>
                                
                                <div class="col-sm-10">
                                @if($task->attachment)
                                    <a href="/task_attachment/{{$task->attachment}}" target="new">
                                        <input type="text" class="form-control" value="{{$task->attachment}}" readonly>
                                    </a>
                                    <br>
                                @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label>Change Attachment @if($task->id_task)<small>(Leave Empty to keep attachment as it is)</small>@endif</label>
                                </div>
                                
                                <div class="col-sm-10">
                                    <input  name="attachment" type="file" class="form-control " id="subject" aria-describedby="namaHelp" accept="image/*">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </td>
                <td style="width:50%;">
                    <div class="col-md-5x">
                        <p class="judul1">Work time</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                @if($task_detail->request_start_time != '')
                                    <label for="request_start_time">Request Start Time</label><br>
                                    <input type="date" class="form-control" name="request_start_time" id="request_start_time" required autofocus 
                                @if(old('request_start_time')) value="{{old('request_start_time')}}" @elseif($task_detail->request_start_time) value="{{date('Y-m-d', strtotime($task_detail->request_start_time))}}" @endif
                                >
                                @endif
                                </div>
                            </div>
                            <div class="col-md-6" style="padding-right:22px;">
                                <div class="form-group">
                                @if($task_detail->request_complete_time != '')
                                    <label for="request_complete_time">Request Completion</label><br>
                                    <input type="date" class="form-control" name="request_complete_time" required autofocus 
                                @if(old('request_complete_time')) value="{{old('request_complete_time')}}" @elseif($task_detail->request_complete_time) value="{{date('Y-m-d', strtotime($task_detail->request_complete_time))}}" @endif
                                >
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        @if($task_detail->total_hari_kerja != '')
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="subject">Total hari pekerjaan</label>
                                </div>
                                
                                <div class="col-sm-10">
                                            <input type="text" class="form-control" name="total_hari_kerja" required autofocus 
                                @if(old('total_hari_kerja')) value="{{old('total_hari_kerja')}}" @elseif($task_detail->total_hari_kerja) value="{{$task_detail->total_hari_kerja}}" @endif
                                >
                                </div>
                            </div>
                        @endif
                        </div>
                        <div class="form-group">
                        @if($task->id_technician != '')
                        
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label>Assin To</label><br>
                                </div>
                                
                                <div class="col-sm-10">
                                    <select class="form-control select2" style="width: 100%;" required autofocus name="id_technician">
                                    <option selected="selected" disabled value="">-- Select Assign To --</option>
                                @foreach(\App\Model\Technician::get() as $tech)
                                    <option value="{{$tech->id_technician}}" @if(old('id_technician') == $tech->id_technician || $task->id_technician == $tech->id_technician) selected @endif>{{$tech->name_technician}}</option>
                                @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <hr>
                        </div>
                        <p class="judul1 pt-5">Down Time</p>
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="form-group">
                                @if($task_detail->down_start != '')
                                    <label for="subject">Waktu Mulai</label><br>
                                    <input type="date" class="form-control" name="down_start" id="down_start" required autofocus 
                                @if(old('down_start')) value="{{old('down_start')}}" @elseif($task_detail->down_start) value="{{date('Y-m-d', strtotime($task_detail->down_start))}}" @endif
                                >
                                @endif
                                </div>
                            </div>
                            <div class="col-md-6" style="padding-right:22px;">
                                <div class="form-group">
                                @if($task_detail->down_end != '')
                                    <label for="subject">Waktu Selesai</label><br>
                                    <input type="date" class="form-control" name="down_end" id="down_end" required autofocus 
                                @if(old('down_end')) value="{{old('down_end')}}" @elseif($task_detail->down_end) value="{{date('Y-m-d', strtotime($task_detail->down_end))}}" @endif
                                >
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        @if($task_detail->total_waktu_kerja != '')
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="subject">Total Waktu Kerja</label><br>
                                </div>
                                
                                <div class="col-sm-10">
                                                <input type="text" class="form-control" name="total_waktu_kerja" required autofocus 
                                    @if(old('total_waktu_kerja')) value="{{old('total_waktu_kerja')}}" @elseif($task_detail->total_waktu_kerja) value="{{$task_detail->total_waktu_kerja}}" @endif
                                    >
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        
        <div class="col-md-1"></div>
        
    </div>
</div>


<script>
    $('.select2').select2();
    $(document).ready(function(){
        @if($task->id_category)
            $('.select_category').val({{$task->id_category}}).trigger('change');
        @endif
    });
    
    $(document).ready(function(){
    $(this).on("click","#hide", function(){
        var target_input = $(this).parent();
        target_input.remove();
    });
    });
</script>
