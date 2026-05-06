package com.clinic.clinic_app.dto;

import com.clinic.clinic_app.model.AppointmentStatus;
import lombok.Data;

@Data
public class AppointmentSearchForm {
    private String patientName;
    private Long doctorId;
    private AppointmentStatus status;
}
