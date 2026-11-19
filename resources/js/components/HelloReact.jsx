import { useMemo, useState } from 'react';

/* ---------- Static data ---------- */

const STATISTICS = [
    { title: 'Total students', value: '250', detail: '+12 this month', icon: 'bi-people-fill', tone: 'primary', percentage: 78, up: true },
    { title: 'Total teachers', value: '25', detail: 'Teaching staff', icon: 'bi-person-workspace', tone: 'success', percentage: 65 },
    { title: 'Total classes', value: '12', detail: 'Across all grades', icon: 'bi-building', tone: 'warning', percentage: 55 },
    { title: 'Attendance', value: '94.5%', detail: "Today's attendance", icon: 'bi-calendar-check-fill', tone: 'info', percentage: 94.5, up: true },
];

const ACTIVITIES = [
    { title: 'Student registration', description: 'New admissions completed', progress: 75, tone: 'primary' },
    { title: 'Monthly attendance', description: 'Attendance records updated', progress: 90, tone: 'success' },
    { title: 'Examination preparation', description: 'Exam preparation progress', progress: 60, tone: 'warning' },
];

const ANNOUNCEMENTS = [
    { title: 'Monthly examination', category: 'Monthly', date: '15 November', icon: 'bi-journal-text' },
    { title: 'Parent meeting', category: 'Parent', date: '20 November', icon: 'bi-people' },
    { title: 'Annual sports day', category: 'Annual', date: '25 November', icon: 'bi-trophy' },
];

const EVENT_FILTERS = [
    { value: 'All', label: 'All' },
    { value: 'Monthly', label: 'Exams' },
    { value: 'Parent', label: 'Meetings' },
    { value: 'Annual', label: 'Sports' },
];

const ATTENDANCE = 94.5;

function getGreeting() {
    const hour = new Date().getHours();
    if (hour < 12) return 'Good morning';
    if (hour < 17) return 'Good afternoon';
    return 'Good evening';
}

/* ---------- Small reusable pieces (Bootstrap classes only) ---------- */

function IconBox({ icon, tone = 'primary' }) {
    return (
        <span
            className={`d-inline-flex align-items-center justify-content-center mb-0 rounded-3 fs-5 bg-${tone}-subtle text-${tone}-emphasis`}
            style={{ width: 44, height: 44 }}
            aria-hidden="true"
        >
            <i className={`bi ${icon}`}></i>
        </span>
    );
}

function Progress({ label, value, tone, height = 6 }) {
    return (
        <div
            className="progress"
            style={{ height }}
            role="progressbar"
            aria-label={label}
            aria-valuenow={value}
            aria-valuemin={0}
            aria-valuemax={100}
        >
            <div className={`progress-bar bg-${tone}`} style={{ width: `${value}%` }}></div>
        </div>
    );
}

function CardTitle({ id, title, subtitle, children }) {
    return (
        <div className="d-flex justify-content-between align-items-start gap-3 mb-4">
            <div>
                <h2 id={id} className="h5 fw-bold mb-1">{title}</h2>
                <p className="text-body-secondary small mb-0">{subtitle}</p>
            </div>
            {children}
        </div>
    );
}

/* ---------- Component ---------- */

function HelloReact() {
    const [name, setName] = useState('');
    const [count, setCount] = useState(0);
    const [showWelcome, setShowWelcome] = useState(true);
    const [selectedFilter, setSelectedFilter] = useState('All');

    const trimmedName = name.trim();

    const filteredAnnouncements = useMemo(
        () =>
            selectedFilter === 'All'
                ? ANNOUNCEMENTS
                : ANNOUNCEMENTS.filter(event => event.category === selectedFilter),
        [selectedFilter]
    );

    return (
        <main className="school-dash bg-body-tertiary min-vh-100">
            <div className="container-xxl px-3 px-md-4 py-3 py-md-4">

                {/* Hero */}
                <section className="sd-hero rounded-4 text-white p-4 p-lg-5 mb-4" aria-labelledby="sd-hero-title">
                    <div className="row align-items-center g-4">
                        <div className="col-12 col-md-8">
                            <p className="small text-white-50 mb-1">
                                {new Date().toLocaleDateString(undefined, { weekday: 'long', day: 'numeric', month: 'long' })}
                            </p>

                            <h1 id="sd-hero-title" className="display-6 fw-bold text-break mb-2">
                                {getGreeting()}{trimmedName ? `, ${trimmedName}` : ''}
                            </h1>

                            <p className="text-white-50 mb-4" style={{ maxWidth: '46ch' }}>
                                Here is how your school is doing today. Enter your name to personalise this page.
                            </p>

                            <div className="input-group bg-white rounded-3 overflow-hidden flex-nowrap" style={{ maxWidth: 440 }}>
                                <label htmlFor="sd-name" className="visually-hidden">Your name</label>
                                <span className="input-group-text bg-white border-0" aria-hidden="true">
                                    <i className="bi bi-person"></i>
                                </span>
                                <input
                                    id="sd-name"
                                    type="text"
                                    className="form-control border-0 shadow-none py-2"
                                    placeholder="Enter your name"
                                    autoComplete="given-name"
                                    value={name}
                                    onChange={e => setName(e.target.value)}
                                />
                                <button
                                    type="button"
                                    className="btn btn-light text-primary rounded-0"
                                    onClick={() => setName('')}
                                    disabled={!name}
                                >
                                    Clear
                                </button>
                            </div>
                        </div>

                        {/* Attendance ring */}
                        <div className="col-12 col-md-4 d-flex justify-content-md-end">
                            <div
                                className="sd-ring d-grid rounded-circle p-2"
                                style={{ '--value': ATTENDANCE }}
                                role="img"
                                aria-label={`Today's attendance is ${ATTENDANCE} percent`}
                            >
                                <div className="sd-ring__inner rounded-circle d-flex flex-column align-items-center justify-content-center text-center text-white">
                                    <strong className="fs-3 lh-1">{ATTENDANCE}%</strong>
                                    <small className="text-white-50 mt-1">present today</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Statistics */}
                <section aria-labelledby="sd-stats-title" className="mb-4">
                    <div className="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <div>
                            <h2 id="sd-stats-title" className="h5 fw-bold mb-1">School statistics</h2>
                            <p className="text-body-secondary small mb-0">A quick overview of your school</p>
                        </div>
                        <span className="badge rounded-pill bg-success-subtle text-success-emphasis px-3 py-2">
                            <i className="bi bi-circle-fill me-2 small" aria-hidden="true"></i>
                            Live preview
                        </span>
                    </div>

                    <div className="row g-3">
                        {STATISTICS.map(stat => (
                            <div className="col-12 col-sm-6 col-xl-3" key={stat.title}>
                                <article className="card sd-lift border-0 shadow-sm rounded-4 h-100">
                                    <div className="card-body p-4">
                                        <div className="d-flex justify-content-between align-items-start gap-3">
                                            <div>
                                                <p className="text-body-secondary small mb-1">{stat.title}</p>
                                                <p className="h2 fw-bold mb-2">{stat.value}</p>
                                            </div>
                                            <IconBox icon={stat.icon} tone={stat.tone} />
                                        </div>

                                        <p className={`small mb-3 ${stat.up ? 'text-success' : 'text-body-secondary'}`}>
                                            {stat.up && <i className="bi bi-arrow-up-right me-1" aria-hidden="true"></i>}
                                            {stat.detail}
                                        </p>

                                        <Progress label={stat.title} value={stat.percentage} tone={stat.tone} />
                                    </div>
                                </article>
                            </div>
                        ))}
                    </div>
                </section>

                {/* Counter + interaction */}
                <div className="row g-3 mb-4">
                    <div className="col-12 col-lg-5">
                        <section className="card border-0 shadow-sm rounded-4 h-100" aria-labelledby="sd-counter-title">
                            <div className="card-body p-4">
                                <CardTitle id="sd-counter-title" title="React counter" subtitle="Try updating the value">
                                    <IconBox icon="bi-calculator" tone="primary" />
                                </CardTitle>

                                <div className="bg-body-tertiary rounded-4 p-4 text-center">
                                    <p className="text-body-secondary small mb-1">Current value</p>
                                    <p className="display-4 fw-bold text-primary mb-0" aria-live="polite">{count}</p>
                                </div>

                                <div className="d-flex flex-wrap gap-2 mt-3">
                                    <button type="button" className="btn btn-primary flex-fill" onClick={() => setCount(v => v + 1)}>
                                        <i className="bi bi-plus-lg me-1" aria-hidden="true"></i>
                                        Increase
                                    </button>
                                    <button
                                        type="button"
                                        className="btn btn-outline-primary flex-fill"
                                        onClick={() => setCount(v => Math.max(0, v - 1))}
                                        disabled={count === 0}
                                    >
                                        <i className="bi bi-dash-lg me-1" aria-hidden="true"></i>
                                        Decrease
                                    </button>
                                    <button
                                        type="button"
                                        className="btn btn-light border"
                                        onClick={() => setCount(0)}
                                        disabled={count === 0}
                                        aria-label="Reset counter"
                                        title="Reset"
                                    >
                                        <i className="bi bi-arrow-counterclockwise" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div className="col-12 col-lg-7">
                        <section className="card border-0 shadow-sm rounded-4 h-100" aria-labelledby="sd-interaction-title">
                            <div className="card-body p-4 d-flex flex-column">
                                <CardTitle id="sd-interaction-title" title="React interaction" subtitle="Show and hide content">
                                    <IconBox icon="bi-lightning-charge" tone="success" />
                                </CardTitle>

                                <div className="bg-body-tertiary rounded-4 p-4 d-flex align-items-center gap-3 mt-1" aria-live="polite">
                                    {showWelcome ? (
                                        <>
                                            <IconBox icon="bi-check-lg" tone="success" />
                                            <div>
                                                <h3 className="h6 fw-bold mb-1">Everything is working</h3>
                                                <p className="text-body-secondary small mb-0">This content is rendered by React.</p>
                                            </div>
                                        </>
                                    ) : (
                                        <>
                                            <IconBox icon="bi-eye-slash" tone="secondary" />
                                            <div>
                                                <h3 className="h6 fw-bold mb-1">Content is hidden</h3>
                                                <p className="text-body-secondary small mb-0">Select the button to show it again.</p>
                                            </div>
                                        </>
                                    )}
                                </div>

                                <div className="mt-3 d-grid d-sm-block">
                                    <button
                                        type="button"
                                        className="btn btn-outline-primary"
                                        onClick={() => setShowWelcome(v => !v)}
                                        aria-pressed={!showWelcome}
                                    >
                                        <i className={`bi ${showWelcome ? 'bi-eye-slash' : 'bi-eye'} me-2`} aria-hidden="true"></i>
                                        {showWelcome ? 'Hide content' : 'Show content'}
                                    </button>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                {/* Activities + events */}
                <div className="row g-3">
                    <div className="col-12 col-xl-7">
                        <section className="card border-0 shadow-sm rounded-4 h-100" aria-labelledby="sd-activities-title">
                            <div className="card-body p-4">
                                <CardTitle id="sd-activities-title" title="School activities" subtitle="Progress of current activities" />

                                {ACTIVITIES.map(activity => (
                                    <div className="mb-4" key={activity.title}>
                                        <div className="d-flex justify-content-between align-items-start gap-3 mb-2">
                                            <div>
                                                <h3 className="h6 fw-semibold mb-1">{activity.title}</h3>
                                                <small className="text-body-secondary">{activity.description}</small>
                                            </div>
                                            <strong>{activity.progress}%</strong>
                                        </div>
                                        <Progress label={activity.title} value={activity.progress} tone={activity.tone} height={8} />
                                    </div>
                                ))}
                            </div>
                        </section>
                    </div>

                    <div className="col-12 col-xl-5">
                        <section className="card border-0 shadow-sm rounded-4 h-100" aria-labelledby="sd-events-title">
                            <div className="card-body p-4">
                                <CardTitle id="sd-events-title" title="Upcoming events" subtitle="Important school announcements" />

                                <div className="d-flex gap-2 overflow-auto pb-2 mb-2" role="group" aria-label="Filter events">
                                    {EVENT_FILTERS.map(filter => (
                                        <button
                                            key={filter.value}
                                            type="button"
                                            className={`btn btn-sm rounded-pill mt-0 ${selectedFilter === filter.value ? 'btn-primary' : 'btn-outline-secondary'}`}
                                            aria-pressed={selectedFilter === filter.value}
                                            onClick={() => setSelectedFilter(filter.value)}
                                        >
                                            {filter.label}
                                        </button>
                                    ))}
                                </div>

                                {filteredAnnouncements.length > 0 ? (
                                    <ul className="list-group list-group-flush">
                                        {filteredAnnouncements.map(event => (
                                            <li className="list-group-item d-flex align-items-center gap-3 px-0 py-3" key={event.title}>
                                                <IconBox icon={event.icon} tone="primary" />
                                                <div>
                                                    <h3 className="h6 fw-semibold mb-1">{event.title}</h3>
                                                    <small className="text-body-secondary">
                                                        <i className="bi bi-calendar3 me-1" aria-hidden="true"></i>
                                                        {event.date}
                                                    </small>
                                                </div>
                                            </li>
                                        ))}
                                    </ul>
                                ) : (
                                    <p className="text-body-secondary small pt-3 mb-0">No events in this category yet.</p>
                                )}
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
    );
}

export default HelloReact;