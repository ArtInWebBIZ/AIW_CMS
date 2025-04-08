<h1 class="uk-text-center uk-margin-large-bottom">Algorithm for fair determination of winners</h1>
<p>First, a few words, why and what is this Service for?</p>
<p>Since ancient times, where it is necessary to honestly and impartially determine the winner – they just drew lots. Although it was not always really fair, such a system worked and gave the desired results.</p>
<p>Since the emergence of the Internet, various types of randomizers have appeared. However, for those who use them to draw lots, there are always many methods for manipulation. Participant of such a "lottery" there is nothing left but relying on the authority and trust of the organizer to trust the honesty of the results.</p>
<p>The purpose of our Service is that <strong>no one, ever and in any way, can influence the honest and unbiased determination of the winner or winners</strong>, since <strong>every participant directly affects the result</strong>, contributes its share to the confusion and increase of its uncertainty! Thanks to this, it becomes absolutely impossible to prematurely determine the winner down to the last participant of the competition. The queen of all sciences becomes the queen of all sciences to fight manipulations and frauds – mathematics!</p>
<p><strong>How does it work?</strong></p>
<p>The contest organizer determines how many participants can take part in the contest. Describes the conditions of the event in detail:</p>
<ul>
    <li>how many winners;</li>
    <li>what the participants must present to confirm the correctness of their participation – promo text;</li>
    <li>when and under what conditions the competition will be completed;</li>
    <li>etc.</li>
</ul>
<p>Participants must specify two things in each application for participation in the competition:</p>
<ol>
    <li>Number from the participant;</li>
    <li>Promo text.</li>
</ol>
<p>"Number from participant" is entered by each participant of the competition, and directly affects the determination of the winner (or winners) of this particular competition.</p>
<p>As "Promo text" can appear, for example:</p>
<ul>
    <li>number and date of the ticket to the cinema;</li>
    <li>the number and date of the check in the supermarket;</li>
    <li>order number;</li>
    <li>name of YouTube channel subscriber;</li>
    <li>etc.</li>
</ul>
<p>If the data of the "Promo text" in the application do not meet the requirements contained in the description of the competition, the organizer of the competition has the opportunity to block this application. An application blocked by the contest organizer is not taken into account in all further calculations, but is not removed from the general list of participants' applications.</p>
<p><strong>Both "Number from participant" and "Promo text" can never, by anyone and in any way change!</strong></p>
<p>When all applications for participation in the competition have been submitted, or the competition period has ended and participants have submitted more than 70% of applications, such a competition is considered completed, and the stage of determining the winners begins.</p>
<p>Determining the winners takes place in several steps:</p>
<ol>
    <li>The sum of numbers from all active applications of the competition participants is added.</li>
    <li>A correction number is added to this amount – is determined by the "Full amount".</li>
    <li>"Full amount" is divided by the number of active applications of participants.</li>
    <li>The winner is the participant whose application number, according to the account for this competition, will correspond to the balance of the difference between the "Full amount" and the result of multiplying the number of participants by the whole number obtained in step three.</li>
</ol>
<p>The number of corrections is automatically determined and fixed by the Service when creating each competition. The correction number is hashed using two keys, which are also created for each contest separately. The <strong>Hash of the correction number</strong>, with two keys, is immediately <strong>published in the contest parameters table, and cannot be changed</strong>. After the contest is over, both the keys and the correction number are published in the contest parameters table. Thus, no one can know the result of the "Full Amount" value. until the end of the competition, because until the last application from the participants of the competition "Full amount" is constantly changing, but everyone can easily check that the correction number has not changed in any way since the very beginning of the competition. In addition, after the end of the contest, <strong>every simple visitor to the Service website can easily check the correctness of the determination of the winners through simple mathematical calculations, since all data on each completed contest is completely open.</strong></p>
<p>So.</p>
<p>For example, the sum of numbers from all participants who submitted <strong>258</strong> active bids will be <strong>185760</strong>. Correction number – <strong>359245</strong>.</p>
<p>Determine the winner:</p>
<ol>
    <li>185760 + 359245 = 545005</li>
    <li>545005 / 258 = <strong>2112</strong>,4224…</li>
    <li>2112 * 258 = 544896</li>
    <li>545005 - 544896 = <strong>109</strong></li>
</ol>
<p>The account of participants' applications starts from zero (0). If the result of the calculation according to p. 2 will be a whole number without a remainder, the first participant becomes the winner, since the difference between the "Full amount" and the result of the calculation according to point 4 will be zero.</p>
<p>If, after determining the winner, the contest organizer found that the data of the "Promo text" in the application do not meet the requirements contained in the description of the competition, the organizer of the competition has the opportunity to block this application, and the determination of the winner continues without taking into account the blocked application of the participant.</p>
<p>If necessary, any number of winners can be determined (no more than the number of participants). At the same time, the application of the previous winner is not taken into account. Thus, all numbers change (except for the correction number).</p>
<p>For example, "Number from user" in application <strong>109</strong> there were <strong>593</strong>. Then the next winner will be determined as follows:</p>
<ol>
    <li>(185760 - 593) + 359245 = 544412</li>
    <li>544412 / 257 = <strong>2118</strong>,3346…</li>
    <li>2118 * 257 = 544326</li>
    <li>544412 - 544326 = <strong>86</strong></li>
</ol>
<p>Within the number of contest participants <strong>any number of winners can be determined, without any possibility to predict the result in advance</strong>.</p>
