package com.clinic.clinic_app.repository;

import com.clinic.clinic_app.model.Doctor;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface DoctorRepository extends JpaRepository<Doctor, Long> {
    List<Doctor> findByActiveTrueOrderByFullNameAsc();

    List<Doctor> findByFullNameContainingIgnoreCaseOrSpecializationContainingIgnoreCase(String fullName, String specialization);
}
