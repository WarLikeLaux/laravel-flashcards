<?php

namespace Database\Seeders\Data\Categories\SystemDesign;

class Architecture
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example: ?string, code_language: ?string, difficulty: int, topic: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое монолит простыми словами?',
                'answer' => 'Монолит - это одно большое приложение, в котором весь код (бизнес-логика, БД, UI) живёт вместе и деплоится одной "коробкой". Простыми словами: представь огромный швейцарский нож - один инструмент со всеми функциями. Плюсы: проще разрабатывать, дебажить, деплоить. Минусы: сложно масштабировать отдельные части, любая ошибка может уронить всё, тяжёлый деплой.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое микросервисы простыми словами?',
                'answer' => 'Микросервисы - это разбиение большого приложения на маленькие независимые сервисы, каждый отвечает за свою бизнес-задачу и общается с другими через сеть (HTTP, очереди). Простыми словами: вместо одного большого швейцарского ножа у тебя набор отдельных инструментов. Сервис заказов, сервис платежей, сервис уведомлений - каждый можно разрабатывать, деплоить и масштабировать отдельно.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие плюсы и минусы у микросервисов по сравнению с монолитом?',
                'answer' => 'Плюсы микросервисов: независимое масштабирование, разные технологии, изоляция отказов, независимые деплои, маленькие команды владеют сервисами. Минусы: сложность инфраструктуры (k8s, service mesh), сетевые задержки, распределённые транзакции, дебаг через множество сервисов, нужны DevOps-практики, eventual consistency. Монолит проще для маленьких команд, микросервисы оправданы при росте.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Service-Oriented Architecture (SOA)?',
                'answer' => 'SOA - предшественник микросервисов: приложение разбивается на сервисы, общающиеся через корпоративную шину (ESB). Сервисы крупнее микросервисов, обмен идёт через SOAP/XML, ESB централизует маршрутизацию и трансформации. Главное отличие от микросервисов: тяжёлая централизованная шина и крупные сервисы. Микросервисы - облегчённый SOA с REST/gRPC и без ESB.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое 3-х уровневая архитектура?',
                'answer' => '3-tier architecture - разделение приложения на три слоя: 1) Presentation (UI, фронтенд), 2) Business Logic (бэкенд, контроллеры, сервисы), 3) Data (БД, файловое хранилище). Каждый слой общается только со смежным. Это классика для веб-приложений, простыми словами: фронт спрашивает у бэка, бэк спрашивает у БД, никто не лезет через слой.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое гексагональная архитектура (Ports and Adapters)?',
                'answer' => 'Hexagonal architecture - подход, где доменная логика в центре, а вокруг "порты" (интерфейсы) и "адаптеры" (конкретные реализации: HTTP, БД, очередь). Простыми словами: ядро приложения не знает, откуда пришёл запрос (CLI, HTTP, тест) и куда сохраняются данные (Postgres, файл). Это даёт тестируемость и возможность менять инфраструктуру не трогая бизнес-логику.',
                'code_example' => '<?php
// Порт (интерфейс)
interface OrderRepository {
    public function save(Order $order): void;
}

// Адаптер для Postgres
class PgOrderRepository implements OrderRepository {
    public function save(Order $order): void { /* SQL */ }
}

// Адаптер для тестов
class InMemoryOrderRepository implements OrderRepository {
    private array $items = [];
    public function save(Order $order): void { $this->items[] = $order; }
}',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Clean Architecture?',
                'answer' => 'Clean Architecture (Дядя Боб) - концентрические слои, зависимости направлены только внутрь. Слои снаружи внутрь: Frameworks & Drivers, Interface Adapters, Use Cases, Entities. Простыми словами: бизнес-правила (entities, use cases) не зависят от Laravel, Postgres или REST - можно переключить любой внешний слой не трогая ядро. Чем-то похоже на гексагональную, но с явной иерархией слоёв.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Onion Architecture?',
                'answer' => 'Onion Architecture - вариация Clean Architecture со слоями-кольцами луковицы. Центр - Domain Model (сущности), вокруг Domain Services, Application Services, на периферии Infrastructure (БД, UI, тесты). Зависимости направлены внутрь: внешние слои знают о внутренних, но не наоборот. Идея: бизнес-логика стабильна, инфраструктура меняется - значит инфраструктура должна зависеть от логики, а не наоборот.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Bounded Context в DDD?',
                'answer' => 'Bounded Context (ограниченный контекст) - область, в которой каждое понятие имеет одно конкретное значение. Простыми словами: слово "клиент" в контексте отдела продаж - это потенциальный покупатель, в контексте доставки - адресат. Это разные модели, поэтому их разделяют. В микросервисах bounded context часто соответствует одному сервису. Связь между контекстами описывается через Anti-Corruption Layer.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Anti-Corruption Layer?',
                'answer' => 'Anti-Corruption Layer (ACL) - прослойка между двумя bounded contexts, которая транслирует данные и не даёт чужой модели "испортить" твою. Простыми словами: переводчик на границе, который превращает данные внешнего сервиса (например, легаси-CRM) в чистые объекты твоего домена. Если завтра CRM поменяют - правишь только ACL, остальной код не трогаешь.',
                'code_example' => '<?php
class LegacyCrmAcl {
    public function __construct(private LegacyCrmClient $crm) {}

    public function getCustomer(int $id): Customer {
        $raw = $this->crm->getClientData($id);
        return new Customer(
            id: $raw["client_id"],
            name: $raw["full_name"],
            email: $raw["contact_email"],
        );
    }
}',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое BFF (Backend for Frontend)?',
                'answer' => 'BFF - отдельный бэкенд для каждого фронтенда (web, iOS, Android). Простыми словами: вместо общего API, который пытается угодить всем клиентам, делают отдельный сервис для мобильного и отдельный для веба. Каждый отдаёт ровно те данные и в том формате, что нужен конкретному клиенту. Уменьшает overfetching, упрощает версионирование, но плодит дублирование кода.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое API Gateway?',
                'answer' => 'API Gateway - единая точка входа для всех клиентских запросов в микросервисную систему. Делает: маршрутизацию к нужному сервису, аутентификацию, rate limiting, кэширование, логирование, агрегацию ответов из нескольких сервисов. Простыми словами: швейцар на входе - проверяет билет, направляет в нужный зал, считает посетителей. Примеры: Kong, Tyk, AWS API Gateway, Nginx с конфигами.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое reverse proxy и для чего он нужен?',
                'answer' => 'Reverse proxy - сервер-посредник перед твоим приложением, который принимает запросы клиентов и передаёт их в бэкенд. Простыми словами: секретарь, который принимает звонки и переводит их на нужного сотрудника. Зачем: терминация TLS, балансировка нагрузки, кэш, защита от DDoS, скрытие внутренней инфраструктуры, обслуживание статики. Популярные: Nginx, HAProxy, Caddy, Traefik.',
                'code_example' => 'server {
    listen 443 ssl;
    server_name api.example.com;

    location / {
        proxy_pass http://backend:8000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    }
}',
                'code_language' => 'bash',
                'difficulty' => 2,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Чем reverse proxy отличается от forward proxy?',
                'answer' => 'Forward proxy стоит перед клиентом, скрывает клиента от сервера (корпоративный прокси для выхода в интернет). Reverse proxy стоит перед сервером, скрывает сервер от клиента (Nginx перед Laravel). Простыми словами: forward proxy - это "я хожу через посредника", reverse proxy - это "ко мне приходят через посредника". Для пользователя reverse proxy выглядит как сам сервер.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое load balancer и какие алгоритмы балансировки бывают?',
                'answer' => 'Load balancer - распределяет входящие запросы между несколькими серверами. Алгоритмы: Round Robin (по очереди), Least Connections (на сервер с меньшим числом активных коннектов), Least Response Time, IP Hash (один IP всегда на один сервер), Weighted (с весами по мощности серверов). Sticky session - один пользователь всегда на тот же сервер (нужно для серверной сессии без Redis).',
                'code_example' => 'upstream backend {
    least_conn;
    server backend1.example.com weight=3;
    server backend2.example.com weight=1;
    server backend3.example.com backup;
}',
                'code_language' => 'bash',
                'difficulty' => 3,
                'topic' => 'system_design.architecture',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое sticky session и зачем нужна?',
                'answer' => 'Sticky session (session affinity) - привязка пользователя к одному и тому же серверу для всех его запросов. Простыми словами: если один раз попал на сервер №2, дальше всегда туда же. Нужна когда сессии хранятся в памяти конкретного сервера (file/array driver). Минусы: неравномерная нагрузка, при падении сервера пользователь теряет сессию. Лучше хранить сессии в Redis - тогда sticky не нужны.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.architecture',
            ],
        ];
    }
}
