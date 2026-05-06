package com.clinic.clinic_app.repository;

import com.clinic.clinic_app.model.MedicalService;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface MedicalServiceRepository extends JpaRepository<MedicalService, Long> {
    List<MedicalService> findByActiveTrueOrderByNameAsc();
}
