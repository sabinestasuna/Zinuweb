CREATE DATABASE simple_news;
USE simple_news;

CREATE TABLE `users` (
  `user_id` integer PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(255) UNIQUE,
  `password_hash` varchar(255),
  `name` varchar(255),
  `registration_date` timestamp,
  `is_admin` boolean DEFAULT false,
  `google_id` varchar(255) UNIQUE,
  `facebook_id` varchar(255) UNIQUE
);

CREATE TABLE `articles` (
  `article_id` integer PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255),
  `content` text,
  `author_id` integer,
  `publish_date` timestamp,
  `is_published` boolean DEFAULT true,
  `category_id` integer
);

CREATE TABLE `comments` (
  `comment_id` integer PRIMARY KEY AUTO_INCREMENT,
  `user_id` integer,
  `article_id` integer,
  `content` text,
  `date_posted` timestamp
);

CREATE TABLE `images` (
  `image_id` integer PRIMARY KEY AUTO_INCREMENT,
  `article_id` integer,
  `image_path` varchar(255),
  `upload_date` timestamp
);

CREATE TABLE `categories` (
  `category_id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255)
);

ALTER TABLE `articles` ADD FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`);
ALTER TABLE `articles` ADD FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
ALTER TABLE `comments` ADD FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`);
ALTER TABLE `comments` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
ALTER TABLE `images` ADD FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`);

INSERT INTO users (email, password_hash, name, registration_date, is_admin, google_id, facebook_id)
VALUES
('user1@example.com', 'hash1', 'User One', NOW(), false, NULL, NULL),
('admin@example.com', 'hash2', 'Admin User', NOW(), true, NULL, NULL),
('user2@example.com', 'hash3', 'User Two', NOW(), false, NULL, NULL),
('user3@google.com', 'hash4', 'User Three', NOW(), false, 'g-123456', NULL),
('user4@facebook.com', 'hash5', 'User Four', NOW(), false, NULL, 'f-123456');

INSERT INTO categories (name)
VALUES
('Sports'),
('Tehnoloģijas'),
('Ziņas'),
('Izklaide');

INSERT INTO articles (title, content, author_id, publish_date, is_published, category_id)
VALUES
('Merzļikins priecājas būt izlasē, atvainojas aizskartajiem faniem un nav priecīgs par mediju attieksmi ', 'Vārtsargs Elvis Merzļikins saviem komandas biedriem Latvijas hokeja izlasē ir gatavs atdot visu, tomēr atgriešanās dzimtenē viņam bijusi ar divējādām sajūtām, pirmdien sarunā ar Latvijas žurnālistiem teica hokejists.<br>Merzļikins pagājušajā nedēļā noslēdza sezonu Nacionālajā hokeja līgā (NHL), kur Kolumbusas "Blue Jackets" sastāvā 41 mačā izcīnīja 13 uzvaras, vidēji ielaida 3,45 ripas un atvairīja 89,7% metienu. Svētdien viņš ieradās Latvijā un jau pirmdienas rītā pievienojās izlases treniņiem, gatavojoties pasaules čempionātam.', 1, NOW(), true, 1),
('Jokičs, Dončičs vai Gildžess-Aleksandrs – kurš būs NBA sezonas vērtīgākais spēlētājs? ', 'Uz Nacionālās basketbola asociācijas (NBA) sezonas vērtīgākā spēlētāja jeb MVP balvu pretendē Nikola Jokičs no Denveras "Nuggets", Luka Dončičs no Dalasas "Mavericks" un Šejs Gildžess-Aleksandrs no Oklahomasitijas "Thunder", svētdien paziņoja līga.<br>Jokičs starp trim finālistiem uz MVP balvu ir jau ceturto gadu pēc kārtas, pie balvas tiekot 2021. un 2022.gadā, bet pērn finišēja otrais aiz Filadelfijas "76ers" spēlētāja Džoela Embīda.<br>Embīds un Milvoki "Bucks" spēlētājs Jannis Adetokunbo bija MVP finālisti līdzās Jokičam katrā no iepriekšējām divām sezonām, taču šosezon viņus nomainīja Gildžess-Aleksandrs un Dončičs.', 2, NOW(), true, 1),
('Netflix peļņai un abonentu skaitam būtisks kāpums', 'ASV filmu un televīzijas seriālu straumēšanas platforma "Netflix" ceturtdien paziņoja, ka šī gada pirmajā ceturksnī būtiski pieaugusi gan peļņa, gan abonentu skaits.<br>"Netflix" abonentu skaits pirmajā ceturksnī palielinājies par 9,3 miljoniem un sasniedzis 269,6 miljonus.<br>Vienlaikus uzņēmuma peļņa šī gada pirmajos trīs mēnešos pieaugusi līdz 2,3 miljardiem eiro, salīdzinot ar 1,3 miljardiem eiro attiecīgajā laika periodā pirms gada.', 3, NOW(), true, 2),
('AS Balticom uzspiež pakalpojumus deviņdesmito gadu stilā?', '"Dienas Biznesa" (DB) rīcībā ir nonākusi informācija, ka elektronisko sakaru pakalpojuma sniedzējs AS “Balticom” cenšas uzspiest klientiem tās pakalpojuma “modernizāciju”, bet, ja piekrišana netiek saņemta vai netiek atbildēts uz telefonu zvaniem, AS “Balticom” negaidīti atslēdz iepriekš jau apmaksātu pakalpojumu.<br>Šķita, ka tamlīdzīgas komercprakses izpausmes ir deviņdesmito gadu pagātne, tāpēc DB nolēma izpētīt, vai tiešām AS “Balticom” bezbailīgi uzskata, ka viņiem ir imunitāte pret patērētāju tiesībām.<br>Informāciju par šādu atgadījumu sniedza kāds DB lasītājs, kurš pastāstīja, ka šaubas par AS “Balticom” profesionalitāti viņam radušās jau īsi pēc līguma noslēgšanas, kad AS “Balticom” darbinieki uzstādot pakalpojumu nodarījuši kaitējumu īpašumam – izurbuši caurumus grīdās un sienās, krustām šķērsām izlaiduši kabeļus cauri visai mājai un beigās atstājuši uz zemes mētājamies dažādus vadus, kas galu galā ar internetu apgādā arī kaimiņu īpašumu. Samierinājies ar nepatīkamo pieredzi, viņš līgumu nelauza un tālākā sadarbībā nekas neliecināja, ka radīsies problēmas – AS “Balticom” internets bijis labs, vienīgi nav bijis patīkami, ka TV kanālu klāstā bijuši daudzi Krievijas propagandas kanāli, piebilda DB lasītājs, nu jau bijušais AS “Balticom” klients.', 3, NOW(), true, 2),
('Polija gatava izvietot kodolieročus savā teritorijā, paziņo Duda', 'Polija ir gatava savā teritorijā izvietot kodolieročus NATO programmas "Nuclear Sharing" ietvaros, intervijā medijam "Fakt" atklājis Polijas prezidents Andžejs Duda.<br>Kā stāsta prezidents, šis jautājums jau kādu laiku ir Polijas-ASV sarunu temats.<br>"Atzīstos, kad man par to jautāja, es paudu mūsu gatavību," teica Duda.<br>Viņš atzīmē, ka Krievija pastiprina Karaļauču militarizāciju un ir izvietojusi kodolieročus Baltkrievijā.', 3, NOW(), true, 3),
('Ukraiņi sašāvuši cara Nikolaja II meitas iesvētītu kuģi', 'Glābšanas kuģi "Komūna" ("Коммуна") ūdenī nolaida 1913. gadā Sanktpēterburgā, un par tā krustmāti kļuva Krievijas impērijas pēdējā cara Nikolaja II meita kņaziene Marija. Neticamā kārtā 111 gadus vecais kuģis ir izdzīvojis līdz mūsdienām un joprojām atrodas Krievijas jūras spēku Melnās jūras flotes dienestā. Aizvadītajās brīvdienās Ukrainas jūras spēki šo kuģi sašāva, un tas vairs nav spējīgs pildīt dienesta pienākukmus.<br>Kreisera "Moskva", kas bija arī Krievijas Melnās jūras flotes flagmanis, nogremdēšana pagaidām ir viena no lielākajām ukraiņu uzvarām Krievijas karā pret Ukrainu. 13. aprīlī "Moskva" trāpīja divas Ukrainas pretkuģu raķetes "Neptun". Uz kreisera izcēlās ugunsgrēks, pēc vairākām stundām tas nogrima un šobrīd guļ aptuveni 90 metru dziļumā Melnās jūras dzelmē netālu no Odesas. Uz kuģa atradās ne tikai raķetes un cits nopietns bruņojums, bet arī kristiešu relikvija – dažus milimetrus liela skaida no krusta, pie kura bija piesists Jēzus Kristus.', 3, NOW(), true, 3),
('Apmeklētajiem durvis vērs jaunā Piejūras brīvdabas muzeja ēka Ventspilī', 'Šī gada 27. aprīlī Ventspilī apmeklētajiem atvērs jauno Piejūras brīvdabas muzeja ekspozīciju, tāpat jaunumi gaidīs muzeja āra teritorijā.<br>Kā "Delfi" informē Ventspils muzeja pārstāvji, jaunā Piejūras brīvdabas muzeja ēka ir daļa no apjomīgā projekta "Ziemeļkurzemes kultūrvēsturiskā un dabas mantojuma saglabāšana, eksponēšana un tūrisma piedāvājuma attīstība". 2018. gada 17. janvārī tika parakstīts līgums ar Centrālo finanšu un līgumu aģentūru par šī projekta īstenošanu, kura ietvaros Ventspils muzejs kopā ar Ventspils Komunālo pārvaldi īstenoja divas aktivitātes – tika izveidota infrastruktūra Ventspilī, dienvidrietumu rajonā, Pelēkās kāpas sasniedzamībai un saglabāšanai un Ventspils Piejūras brīvdabas muzeja apbūve.', 3, NOW(), true, 4),
('Teilore Svifta ar jauno albumu pārspēj vēl vienu rekordu', 'Teilores Sviftas jaunais albums “Mocīto dzejnieku nodaļa” (“The Tortured Poets Department”) platformā “Spotify” kļuvis par visvairāk straumēto vienas dienas laikā, raksta britu raidsabiedrība BBC.<br>Svifta arī kļuvusi par visstraumētāko mākslinieci vienas dienas laikā.<br>Jaunais un fanu ilgi gaidītais albums tika laists klajā piektdien un tajā ir 31 skaņdarbs, kurā popzvaigzne izdzied savas sirdssāpes un dusmas uz bijušajiem partneriem.', 3, NOW(), true, 4),


INSERT INTO comments (user_id, article_id, content, date_posted)
VALUES
(1, 1, 'Interesants raksts, paldies par dalīšanos!', NOW()),
(2, 1, 'Nepiekrītu autoram, bet labi rakstīts.', NOW()),
(3, 2, 'Vairāk šādu rakstu lūdzu.', NOW());

INSERT INTO images (article_id, image_path, upload_date)
VALUES
(1, 'uploads/merzlikins.jpg', NOW()),
(2, 'uploads/nba.jpg', NOW()),
(3, 'uploads/netflix.jpg', NOW()),
(4, 'uploads/balticom.jpg', NOW()),
(5, 'uploads/polija.jpg', NOW()),
(6, 'uploads/kugis.jpg', NOW()),
(7, 'uploads/ventspils.jpg', NOW()),
(8, 'uploads/taylor.jpg', NOW()),