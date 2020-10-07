# DT173G, Moment 5 (Del 1)

Detta repository innehåller koden för ett enklare REST API byggt i PHP.
APIet är byggt för att hantera olika kurser som jag studerat under min tid på Mittuniversitetet.
En liveversion av APIet finns tillgänligt på https://studenter.miun.se/~joni1307/DT173G/Moment5/Del1/api.php

## Endpoints
Nedan finns beskrivet hur man nå APIet på olika vis:

|Method |Endpoint     |Beskrivning                                                                            |
|-------|-------------|---------------------------------------------------------------------------------------|
|GET    |/api.php     |Hämtar alla tillgängliga kurser.                                                       |
|GET    |/api.php?=ID |Hämtar en specifik kurs med angivet ID.                                                |
|POST   |/api.php     |Lagrar en ny kurs. Kräver att ett kurs-objekt skickas med.                             |
|PUT    |/api.php?=ID |Uppdaterar en existerande kurs med angivet ID. Kräver att ett kurs-objekt skickas med. |
|DELETE |/api.php?=ID |Raderar en kurs med angivet ID.                                                        |

Ett kurs-objekt skickas som JSON och kan se ut såhär:
```
{
   code: 'DT173G',
   name: 'Webbutveckling III',
   progression: 'B',
   syllabus: 'https://www.miun.se/utbildning/kursplaner-och-utbildningsplaner/Sok-kursplan/kursplan/?kursplanid=21873'
}
```