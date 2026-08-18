import { Chart } from "chart.js";

let chart =null;
export function renderPerkembanganChart(elementId,data){

    const canvas =document.getElementById(elementId)
    if(!canvas) return;
    if(chart){
        chart.destroy();
    }
    chart = new Chart(canvas,{
        type:'bar',
        data:{
            labels:data.map(item=>item.minggu),
            datasets:[{
                label:'Ayat Baru',
                data:data.map(item=>item.jumlah_ayat),
                borderRadius:8,
                backgroundColor:'#dc2626'
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{
                legend:{
                    display:false
                }
            },
            scales:{
                x:{
                    grid:{
                        display:false
                    }
                },
                y:{
                    beginAtZero:true,
                    ticks:{
                        precision:0
                    }
                }
            }
        }
    })
}
