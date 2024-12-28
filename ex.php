<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Calendar</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        /* Calendar Styling */
        .calendar {
            max-width: 700px;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .calendar-header {
            background-color: #4caf50;
            color: #fff;
            text-align: center;
            padding: 15px;
            font-size: 1.5rem;
        }

        .calendar table {
            width: 100%;
            border-collapse: collapse;
        }

        .calendar th {
            background-color: #34a853;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .calendar td {
            height: 80px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        .calendar td:hover {
            background-color: #e8f5e9;
        }

        .event-day {
            background-color: #81c784;
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            line-height: 40px;
            display: inline-block;
        }

        .today {
            border: 2px solid #4caf50;
            border-radius: 50%;
        }

        /* Modal Styling */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1000;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 1001;
        }

        .modal h3 {
            margin: 0 0 10px;
            font-size: 1.5rem;
            color: #333;
        }

        .modal p {
            font-size: 1rem;
            color: #555;
        }

        .modal .close-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #000000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .modal .close-btn:hover {
            background-color: #388e3c;
        }
    </style>
</head>

<body>

    <h2>Event Calendar</h2>
    <div class="calendar" style="color:yellow">
        <div class="calendar-header" style="background-color:#000000">
            <?php
            $currentMonth = date('F');
            $currentYear = date('Y');
            echo "$currentMonth $currentYear";
            ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                $firstDayOfMonth = date('w', strtotime(date('Y-m-01')));
                $day = 1;

                for ($i = 0; $i < 6; $i++) {
                    echo "<tr>";
                    for ($j = 0; $j < 7; $j++) {
                        if ($i === 0 && $j < $firstDayOfMonth || $day > $daysInMonth) {
                            echo "<td></td>";
                        } else {
                            echo "<td class='date-cell' data-date='" . date('Y-m-') . $day . "'>
                                    <span class='event-day" . ($day === (int) date('j') ? " today" : "") . "' style='background-color:blue ' >$day</span>
                                  </td>";
                            $day++;
                        }
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal-overlay"></div>
    <div class="modal">
        <h3>Event Details</h3>
        <p class="modal-content">No events available.</p>
        <button class="close-btn">Close</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dateCells = document.querySelectorAll('.date-cell');
            const modal = document.querySelector('.modal');
            const overlay = document.querySelector('.modal-overlay');
            const closeModal = document.querySelector('.close-btn');
            const modalContent = document.querySelector('.modal-content');

            dateCells.forEach(cell => {
                cell.addEventListener('click', () => {
                    const selectedDate = cell.getAttribute('data-date');
                    fetch(`fetch_events.php?date=${selectedDate}`)
                        .then(response => response.json())
                        .then(data => {
                            modalContent.innerHTML = data.length > 0
                                ? data.map(event => `<p><strong>${event.title}</strong><br>${event.start}</p>`).join('')
                                : '<p>No events available for this date.</p>';
                            modal.style.display = 'block';
                            overlay.style.display = 'block';
                        });
                });
            });

            closeModal.addEventListener('click', () => {
                modal.style.display = 'none';
                overlay.style.display = 'none';
            });
        });
    </script>

</body>

</html>