package com.clinic.clinic_app.model;

public enum AppointmentStatus {
    NEW("Новая"),
    APPROVED("Подтверждена"),
    CANCELLED("Отменена");

    private final String label;

    AppointmentStatus(String label) {
        this.label = label;
    }

    public String getLabel() {
        return label;
    }
}
