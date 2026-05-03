<?php

namespace Database\Seeders\Data\Categories\SystemDesign;

class Devops
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example: ?string, code_language: ?string, difficulty: int, topic: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Docker простыми словами?',
                'answer' => 'Docker - технология контейнеризации. Контейнер - это упакованное приложение со всеми зависимостями, которое работает одинаково везде (локально, на стейдже, на проде). Простыми словами: коробка с приложением и всем что ему нужно для жизни. В отличие от VM не виртуализирует ОС - использует ядро хоста, поэтому быстрый и лёгкий. Образ (image) - шаблон, контейнер - запущенный экземпляр. Dockerfile описывает как собрать образ.',
                'code_example' => 'FROM php:8.3-fpm
WORKDIR /var/www
COPY . .
RUN composer install --no-dev --optimize-autoloader
EXPOSE 9000
CMD ["php-fpm"]',
                'code_language' => 'bash',
                'difficulty' => 2,
                'topic' => 'system_design.devops',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Чем Docker отличается от виртуальной машины (VM)?',
                'answer' => 'VM виртуализирует железо - запускает полную гостевую ОС со своим ядром. Docker контейнер использует ядро хоста и изолирован через namespaces/cgroups. Простыми словами: VM - целая отдельная квартира, Docker - комната в квартире хозяина. VM весит гигабайты, стартует минуты. Контейнер весит мегабайты, стартует секунды. VM безопаснее изолирован, контейнер быстрее и легче. Часто используют вместе: VM с Docker внутри.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.devops',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Kubernetes простыми словами?',
                'answer' => 'Kubernetes (k8s) - оркестратор контейнеров. Простыми словами: дирижёр оркестра - управляет десятками/тысячами Docker-контейнеров, решает где их запускать, перезапускает упавшие, балансирует нагрузку, масштабирует под нагрузку. Сам Docker не умеет это, k8s сверху. Основные сущности: Pod (группа контейнеров), Deployment (как развернуть), Service (стабильный адрес для подов), Ingress (маршрутизация HTTP).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.devops',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Pod, Deployment, Service в Kubernetes?',
                'answer' => 'Pod - наименьшая единица k8s, обычно один контейнер (иногда несколько связанных, например app+sidecar). Эфемерный: упал - создаётся новый. Deployment - декларация "хочу N реплик такого пода с такой стратегией обновления". Сам управляет ReplicaSet и подами. Service - стабильная точка входа к набору подов через label selector. У подов меняются IP, у service постоянный. Типы: ClusterIP (внутри), NodePort, LoadBalancer (внешний).',
                'code_example' => 'apiVersion: apps/v1
kind: Deployment
metadata: { name: api }
spec:
  replicas: 3
  selector: { matchLabels: { app: api } }
  template:
    metadata: { labels: { app: api } }
    spec:
      containers:
      - name: api
        image: myapp:1.2
        ports: [{ containerPort: 8000 }]',
                'code_language' => 'bash',
                'difficulty' => 3,
                'topic' => 'system_design.devops',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое blue-green deployment?',
                'answer' => 'Blue-green - стратегия деплоя без простоя. Имеешь две идентичные среды: blue (текущая прод) и green (новая версия). Деплоишь в green, прогоняешь тесты, переключаешь трафик с blue на green одной командой (через load balancer или DNS). Если проблема - моментально переключаешь обратно. Плюсы: instant rollback, нет downtime. Минусы: двойные ресурсы, миграции БД сложнее (схема должна работать с обеими версиями).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.devops',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое canary deployment?',
                'answer' => 'Canary deploy - постепенный rollout: новая версия сначала получает 1% трафика, потом 5%, 25%, 100%. Простыми словами: канарейка в шахте - если что-то не так, потеряем малость. Метрики (ошибки, latency) на каждом этапе сравниваются с baseline - если ухудшение, автоматический rollback. Плюсы: маленький blast radius при ошибках. Минусы: нужна инфраструктура для маршрутизации (Istio, Linkerd, Argo Rollouts) и хороший observability.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.devops',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое rolling deployment?',
                'answer' => 'Rolling deploy - обновление подов по одному: убрали один старый, подняли один новый, проверили health, повторили. По умолчанию в Kubernetes Deployment. Простыми словами: меняем колёса на машине по одному, не останавливая её. Параметры: maxUnavailable (сколько может быть offline), maxSurge (сколько лишних можно поднять). Минус: во время деплоя одновременно работают обе версии - нужна обратная совместимость БД и API.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.devops',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое feature flags и зачем нужны?',
                'answer' => 'Feature flags (toggles) - условные блоки в коде, включающие/выключающие фичи без редеплоя. Простыми словами: рубильник на новую фичу - можно включить только для тестовых юзеров, потом 10%, потом всем. Плюсы: trunk-based development, A/B тесты, kill switch при проблеме, разделение деплоя и релиза. Минусы: код засоряется if-ами, надо чистить старые флаги. Инструменты: LaunchDarkly, Unleash, GrowthBook, или своя БД-таблица.',
                'code_example' => '<?php
if (Feature::active("new-checkout", $user)) {
    return view("checkout.v2");
}
return view("checkout.v1");',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'system_design.devops',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое 12-factor app?',
                'answer' => '12-factor - методология построения SaaS-приложений. Ключевые: 1) Codebase в git, 2) Dependencies явные, 3) Config в env, 4) Backing services как ресурсы, 5) Build/release/run разделены, 6) Stateless процессы, 7) Port binding, 8) Concurrency через процессы, 9) Disposability (быстрый старт/остановка), 10) Dev/prod parity, 11) Logs как stream stdout, 12) Admin tasks как one-off процессы. Идеология современного облачного приложения.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.devops',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое CI/CD простыми словами?',
                'answer' => 'CI (Continuous Integration) - каждый коммит автоматически собирается и проходит тесты. Простыми словами: что бы ты ни запушил - сразу проверка качества. CD (Continuous Delivery/Deployment) - после успешного CI код автоматически деплоится в стейдж/прод. Delivery - готов к деплою (нажми кнопку), Deployment - деплоится сам. Зачем: ловим баги рано, релизы маленькие и частые. Инструменты: GitHub Actions, GitLab CI, Jenkins, CircleCI, Drone.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'system_design.devops',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Infrastructure as Code (IaC)?',
                'answer' => 'IaC - описание инфраструктуры в коде вместо ручной настройки в UI. Простыми словами: вместо кликов в AWS-консоли пишешь файл, который их сделает за тебя - и его можно ревьюить, версионировать, переиспользовать. Декларативный (Terraform, CloudFormation) - описываешь желаемое состояние. Императивный (Ansible, Chef) - последовательность шагов. Плюсы: воспроизводимость, history через git, code review для инфраструктуры.',
                'code_example' => 'resource "aws_instance" "api" {
  ami           = "ami-0c55b159"
  instance_type = "t3.medium"
  tags = { Name = "api-server" }
}',
                'code_language' => 'bash',
                'difficulty' => 3,
                'topic' => 'system_design.devops',
            ],
            [
                'category' => 'System Design',
                'question' => 'Как обеспечить Graceful Shutdown для PHP-воркеров и Kubernetes-подов?',
                'answer' => 'Graceful shutdown - корректное завершение процесса при получении сигнала остановки: дождаться завершения текущей работы, не принимать новую, освободить ресурсы. Без него при деплое теряются in-flight Job-ы, обрываются HTTP-запросы, остаётся "висящий" state в БД. Механика в Linux: процесс получает SIGTERM (15) - нужно успеть завершиться за grace period; если не успел, через timeout приходит SIGKILL (9), который не перехватывается. Kubernetes по умолчанию даёт terminationGracePeriodSeconds=30 после SIGTERM, потом SIGKILL. Что делать в PHP: 1) В CLI-воркере - pcntl_async_signals(true) + pcntl_signal(SIGTERM, ...) + установить флаг "shouldStop", который проверяется в основном цикле между задачами. 2) Для очередей - Laravel queue:work уже умеет сам ловить SIGTERM/SIGINT и завершается после текущего Job; нужно только настроить правильный --timeout и terminationGracePeriodSeconds > timeout. 3) Для HTTP - php-fpm graceful через kill -USR1/USR2 (master форкает новых воркеров, старые дорабатывают текущие запросы). В Kubernetes: 4) preStop hook на pod (sleep 10) - даёт время сервис-меш / load balancer убрать pod из endpoints до начала остановки, чтобы новые запросы не шли. 5) Readiness probe возвращает unready при получении SIGTERM. 6) terminationGracePeriodSeconds = max время вашей задачи + buffer. Для Octane/Swoole/RoadRunner - встроенная поддержка graceful reload. Подводный камень: в Kubernetes SIGTERM приходит ДО того, как pod удалён из endpoints - всегда нужен preStop sleep либо корректная readiness-проверка.',
                'code_example' => '<?php
// 1. Свой воркер с обработкой SIGTERM
pcntl_async_signals(true);
$shouldStop = false;
pcntl_signal(SIGTERM, function () use (&$shouldStop) { $shouldStop = true; });
pcntl_signal(SIGINT,  function () use (&$shouldStop) { $shouldStop = true; });

while (! $shouldStop) {
    $job = $this->queue->pop();
    if ($job) {
        $job->handle(); // дорабатываем до конца, не прерываем
    } else {
        sleep(1);
    }
}
$this->cleanup(); // close DB, flush metrics

// 2. Laravel queue:work уже умеет; supervisor:
// stopsignal=TERM
// stopwaitsecs=120

// 3. Kubernetes Deployment
// spec:
//   template:
//     spec:
//       terminationGracePeriodSeconds: 120
//       containers:
//       - name: worker
//         lifecycle:
//           preStop:
//             exec:
//               command: ["sh","-c","sleep 10"] # дать LB убрать из endpoints
//         readinessProbe:
//           httpGet: { path: /healthz, port: 8000 }
//         # SIGTERM -> воркер дожимает, SIGKILL через 120s

// 4. php-fpm graceful reload
// kill -USR2 $(cat /var/run/php-fpm.pid) # перезагрузка с дописыванием текущих',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'system_design.devops',
            ],
        ];
    }
}
