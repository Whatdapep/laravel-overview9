// import { Chart } from "chart.js";
import React, { useEffect, useState } from "react";
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js";
import { Bar } from "react-chartjs-2";

import faker from "faker";

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
);

const Analyst = () => {
    const [DataBarChart, setDataBarChart] = useState();
    const [DataDepositList, setDataDepositList] = useState();
    const [DataWithdrawList, setDataWithdrawList] = useState();
    useEffect(() => {
        feed_data();
        async function feed_data() {
            const DataBuilder = { year: "2021" };
            const userdata_URI = "/api/deposit_dep_and_withdraw_summary_year";

            const requestUser = await fetch(userdata_URI, {
                method: "POST",
                body: JSON.stringify(DataBuilder),
                headers: new Headers({
                    Accept: "application/json",
                    ContentType: "application/json  charset=UTF-8",
                }),
            }).then((response) => {
                return response.json();
            });

            await setDataBarChart(requestUser);
        }
    }, []);

    console.log(DataBarChart);

    const options = {
        responsive: true,
        plugins: {
            legend: {
                position: "top",
            },
            title: {
                display: true,
                text: "ประมวลยอดการฝาก/ถอนเงินในบัญชีเงินฝาก",
            },
        },
    };

    const labels = [
        "Jan 2021",
        "Feb 2021",
        "Mar 2021",
        "Apr 2021",
        "May 2021",
        "Jun 2021",
        "Jul 2021",
        "Aug 2021",
        "Sep 2021",
        "Oct 2021",
        "Nov 2021",
        "Dec 2021",
    ];

    // labels.map(() =>
    //                 faker.datatype.number({ min: 50000, max: 2000000 })
    //             ),
    const data = {
        labels,
        datasets: [
            {
                label: "ฝาก",
                data: DataDepositList
                    ? DataDepositList
                    : labels.map(() =>
                          faker.datatype.number({ min: 4000, max: 1500000 })
                      ),
                backgroundColor: "rgba(53, 162, 235, 0.5)",
            },
            {
                label: "ถอน",
                data: DataWithdrawList
                    ? DataWithdrawList
                    : labels.map(() =>
                          faker.datatype.number({ min: 4000, max: 1500000 })
                      ),
                backgroundColor: "rgba(255, 99, 132, 0.5)",
            },
        ],
    };

    // console.log(DataDepositList);
    // console.log(DataWithdrawList);

    useEffect(async () => {
        if (DataBarChart && DataBarChart.deposit) {
            let ArrDep = [];
            let ArrWithDraw = [];

            await labels.map((val, i) => {
                console.log(i);
                ArrDep.push(
                    parseFloat(DataBarChart.deposit[i].sum_deposit_balance)
                );
                ArrWithDraw.push(
                    parseFloat(DataBarChart.withdraw[i].sum_deposit_balance)
                );
            });

            // console.log(ArrDep, ArrWithDraw);
            setDataDepositList(ArrDep);
            setDataWithdrawList(ArrWithDraw);
        }
    }, [DataBarChart]);

    return (
        <div>
            <h1>Hello Analyst</h1>

            <canvas id="chart"></canvas>

            <Bar options={options} data={data} />
        </div>
    );
};

export default Analyst;
