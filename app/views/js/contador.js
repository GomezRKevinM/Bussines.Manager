let contenedorConfig = {
    year: 2025, // required
    month: 5, // required
    day: 29, // required
    hours: 0, // Default is 0 [0-23] integer
    minutes: 0, // Default is 0 [0-59] integer
    seconds: 0, // Default is 0 [0-59] integer
    words: { //words displayed into the countdown
        days: { singular: 'día', plural: 'días' },
        hours: { singular: 'hora', plural: 'horas' },
        minutes: { singular: 'minuto', plural: 'minutos' },
        seconds: { singular: 'segundo', plural: 'segundos' }
    },
    plural: true, //use plurals
    inline: true, //set to true to get an inline basic countdown like : 24 days, 4 hours, 2 minutes, 5 seconds
    inlineClass: 'simply-countdown-inline', //inline css span class in case of inline = true
    // in case of inline set to false
    enableUtc: false, //Use UTC or not - default : false
    onEnd: function(){ 
        window.location.href="http://localhost/VENTAS/payment/"
        return; }, //Callback on countdown end, put your own function here
    refresh: 1000, // default refresh every 1s
    sectionClass: 'simply-section', //section css class
    amountClass: 'simply-amount', // amount css class
    wordClass: 'simply-word', // word css class
    zeroPad: false,
    countUp: false
};
// if(contenedorConfig.day>7){
//     diaAviso=contenedorConfig.day-7;
//     mes = contenedorConfig.month;
// }else if(contenedorConfig.day<7){
//     mes = contenedorConfig.month-1;
//     numMin = 7 - contenedorConfig.day;
//     diaAviso=30 - numMin;
// }
// let diaAviso;
// let año = contenedorConfig.year;
// let mes;
// let dia = diaAviso;
// let hora = contenedorConfig.hours;
// let minuto = contenedorConfig.minutes;
// let segundo = contenedorConfig.seconds;


 let hiddenConfig = {
     year:2025, // required
     month: 5, // required
     day: 22, // required
     hours: 0, // Default is 0 [0-23] integer
     minutes: 0, // Default is 0 [0-59] integer
     seconds: 0, // Default is 0 [0-59] integer
     words: { //words displayed into the countdown
//         days: { singular: 'día', plural: 'días' },
//         hours: { singular: 'hora', plural: 'horas' },
//         minutes: { singular: 'minuto', plural: 'minutos' },
//         seconds: { singular: 'segundo', plural: 'segundos' }
     },
     plural: true, //use plurals
     inline: true, //set to true to get an inline basic countdown like : 24 days, 4 hours, 2 minutes, 5 seconds
     inlineClass: 'simply-countdown-inline', //inline css span class in case of inline = true
     // in case of inline set to false
     enableUtc: false, //Use UTC or not - default : false
     onEnd: function(){ 
         var hiddenBar = document.getElementById("contadorAfter");
         hiddenBar.style.display="none";
         alert("Comunicate con nosotros, te queda 1 semana para finalizar tú licencia");
         return; }, //Callback on countdown end, put your own function here
     refresh: 1000, // default refresh every 1s
     sectionClass: 'simply-section', //section css class
     amountClass: 'simply-amount', // amount css class
     wordClass: 'simply-word', // word css class
     zeroPad: false,
     countUp: false
 };

simplyCountdown('#contador',contenedorConfig);
 simplyCountdown('#contadorAfter',hiddenConfig);





