package com.clinic.clinic_app.repository;

import com.clinic.clinic_app.model.Appointment;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface AppointmentRepository extends JpaRepository<Appointment, Long> {
    List<Appointment> findAllByOrderByAppointmentTimeDesc();
}
