<style>
    #pdfwrapper {
        display: none;
        padding: 0px 20vw;
        width: auto;
        height: 100vh;
        top: 0;
        position: fixed;
        overflow-y: auto;
        z-index: 1000;
        background-color: white;
    }

    .continueBtn {
        margin: 50px;
        border: none;
        background-color: #70B1FF;
        padding: 10px 20px;
        border-radius: 5px;
        color: white;
        animation-duration: 0.2s;
        max-width: 150px;
    }

    .continueBtn:active {
        background-color: #629BDF;
    }

    #pdfFrame {
        height: max-content;
        max-height: max-content;
        width: 100%;
        font-size: 0.75rem;
    }
    #pdfFrame section{
        height: 100vh;
    }

    .title {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .left-info {
        margin: 40px 0px;
    }

    .title label:first-child {
        font-weight: bold;
        font-size: 20px;
    }

    .subject {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 30px 0px;
    }

    .subject>div {
        width: 80%;
        display: flex;
    }

    .subject-label {
        min-width: 120px;
    }

    .private-content {
        text-align: justify;
        text-justify: inter-word;
    }

    .private-wrapper {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 30px 0px;
    }

    .private-table {
        width: 75%;
    }

    .ending {
        width: 95%;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: flex-end;
    }

    .ending p:first-child {
        margin-right: 80px;
    }

    .next-page {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .next-page>div {
        width: 80%;
        display: flex;
        align-items: center;
        justify-content: space-around;
    }

    .next-page>div label:nth-child(2) {
        white-space: pre-wrap;
    }
 
</style>


<section id="pdfwrapper">
    <button class="continueBtn" onclick="createPdf()">Continue</button>
    <section id="pdfFrame">
        <section>
            <div class="title">
                <label id="mheading">DKC LENDING FL LLC</label>
                <label id="maddress">2110 Park St</label>
                <label id="maddress2">Jacksonville, FL 32204</label>
            </div>
            <div class="left-info">
                <label id="llc">LLC Name</label>
                <br>
                <label id="llc-address">Address</label>
                <br>
            </div>
            <div class="subject">
                <div><label class="subject-label">Re: </label><label> Partial Release Payment for $<label id="amount"></label> to <label id="llcname"></label></label></div>
                <div> <label class="subject-label">Property Address:</label> <label id="property_id">fghsjghdj124 4124 fasfa</label></div>
            </div>
            <div class="private-content">
                To Whom It May Concern:
                <br>
                <label style="margin-top: 70px;"></label>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Per your request, we are providing this payoff information regarding the above-referenced loan:
                <br>
                <div class="private-wrapper">
                    <table class="private-table" id="paidoff-private-table">
                        <tr>
                            <td>Outstanding Principal Balance</td>
                            <td>$</td>
                            <td id="tloanpdf">0.00</td>
                        </tr>
                        <tr>
                            <td>Accrued Interest (<label id="month1"></label> through <label id="month2"></label>)</td>
                            <td>$</td>
                            <td id="accrued">500.00</td>
                        </tr>
                        <tr id="penalty-wrapper">
                            <td>Prepayment Penalty</td>
                            <td>$</td>
                            <td id="penalty">0.00</td>
                        </tr>
                        <tr id="latefee-wrapper">
                            <td>Late Fee</td>
                            <td>$</td>
                            <td id="latefee">0.00</td>
                        </tr>
                        <tr id="extra-wrapper">
                            <td>Prepayment Penalty</td>
                            <td>$</td>
                            <td id="extrafee">0.00</td>
                        </tr>
                        <tr>
                            <td>Lender Admin Fee</td>
                            <td>$</td>
                            <td id="admin">0.00</td>
                        </tr>
                        <tr>
                            <td>Recording Fee</td>
                            <td>$</td>
                            <td id="recording">0.00</td>
                        </tr>
                        <tr>
                            <td>Attorney's Fee</td>
                            <td>$</td>
                            <td id="attorney">0.00</td>
                        </tr>
                        <tr>
                            <td><b>Total Due as of <label id="exdate"></label></b></td>
                            <td><b>$</b></td>
                            <td><b style="border-top:solid 1px black;"><label id="grand">0.00</label></b></td>
                        </tr>
                    </table>
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This payoff letter is good through 5:00 p.m. on <label id="fdate"></label>. Per diem interest for this loan is $<label id="diem">0.00</label>, which must be added to the total amount due for each day thereafter util the date we receive the full payoff.
                <br>
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The outstanding principal balance, accrued interest and all other fees set forth above should be wired directly to our account. For your convenience, our incoming wire instructions are attached as Exhibit “A” to this letter.
                <br>
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Upon receipt of the full payoff amount, we will record a satisfaction of mortgage and a release of the assignment of rents and the UCC financing statement in the public records of the county in which the property is located. Please don't hesitate to contact us with any questions.

                <div class="ending">
                    <p>Sincerely,</p>
                    <p>DKC LENDING LLC</p>

                </div>

            </div>
        </section>
        <section>
            <div class="next-page">
                <center>
                    <p><u>EXHIBIT "A"</u></p>
                    <br>
                    <br>
                    <h1>DKC LENDING LLC</h1>
                    <h2>Incoming Domestic Wire instructions</h2>
                </center>
                <div>
                    <label>Send Funds to:</label>
                    <label id="sender-detail">
                    </label>
                </div>
                <br>
                <br>
                <div>
                    <label>For Final Credit to:</label>
                    <label id="receiver-detail">
                    </label>
                </div>
                <br>
                <p align="left">DKC Lending # to Verify Instructions: 813-501-5729</p>
            </div>
        </section>
    </section>
</section>